<?php

namespace App\Http\Livewire\Project\Bird;

use App\ResourceType;
use App\ResourceCategory;
use App\Project\Bird;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Index extends Component
{
    public $birdDefinition;
    public $birds;
    public $birdIds;
    public $chronoBirds;
    public $perPage = 9;

    public $filterQuery;
    public $filterOrderable;
    public $filterOrderableDirection = 'asc';
    public $filterCategoryBirds;
    public $filterFilterables;
    public $filterMonths;
    public $filterSeasons;

    public $readyToLoad = false;

    protected $listeners = [
        'bird.filter:query-updated' => 'updateByQuery',
        'bird.filter:orderable-updated' => 'updatePoemsByOrderable',
        'bird.filter:bird-updated' => 'updateByBirds',
        'bird.filter:month-updated' => 'updateByMonth',
        'bird.filter:season-updated' => 'updateBySeason',
        'bird.filter:filterable-updated' => 'updatePoemsByFilterables'
    ];

    public function mount()
    {
        $this->birdDefinition = ResourceType::find(19);
        //$this->filterOrderable = $this->birdDefinition->attributes->where('visibility', 1)->first();
    }

    public function loadResources()
    {
        $this->readyToLoad = true;
    }

    public function updateByQuery($query)
    {
        $validator = Validator::make([
            'query' => $query
        ], [
            'query' => ['required', 'string', 'min:2']
        ]);

        if ($validator->fails()) {
            $this->filterQuery = null;
            return;
        }

        $this->filterQuery = $query;
    }

    public function updateByBirds(array $activeBirds)
    {
        $this->filterCategoryBirds = ResourceCategory::whereIn('id', $activeBirds)->get();
    }

    public function updateByMonth(array $activeMonths)
    {
        $this->filterMonths = collect($activeMonths);
    }

    public function updateBySeason(array $activeSeasons)
    {
        $this->filterSeasons = collect($activeSeasons);
    }

    public function getPotentialBirdsProperty()
    {
        return new Bird;
    }

    public function getBirdsFilteredProperty()
    {
        $birds = $this->potentialBirds;

        if ($this->filterCategoryBirds && $this->filterCategoryBirds->count()) {
            $birds = $this->potentialBirds->whereIn('resource_category_id', $this->filterCategoryBirds->pluck('id'));
        }

        if ($this->filterQuery) {
            $query = $this->filterQuery;
            $birds = $birds->where('name', 'like', "%$query%");
        }

        if (optional($this->filterSeasons)->count()) {
            $presenceBirdsConnections = $this->getPresenceConnections($birds);
            
            $filterSeasons = $this->filterSeasons;

            $seasonsDict = [
                2 => [11,12,1],
                3 => [3,4,5],
                4 => [6,7,8],
                5 => [9,10,11]
            ];

            $filteredBirdsByPresence = $presenceBirdsConnections
                ->filter(function($connection) use ($filterSeasons, $seasonsDict) {
                    $bird = $connection->otherBird;

                    $presence = $bird->presenceMeta->value;

                    $months = collect(array_map('trim', explode(',', $presence)));

                    foreach ($filterSeasons as $season) {
                        foreach ($seasonsDict[$season] as $month) {
                            if (collect($months)->contains($month)) {
                                return true;
                            }
                        }
                    }
                });

            $birds = $birds->whereIn('id', $filteredBirdsByPresence->pluck('primary_bird_id'));
        } 
        else if (optional($this->filterMonths)->count()) {
            $presenceBirdsConnections = $this->getPresenceConnections($birds);
            
            $filterMonths = $this->filterMonths;

            $filteredBirdsByPresence = $presenceBirdsConnections
                ->filter(function($connection) use ($filterMonths) {
                    $bird = $connection->otherBird;

                    $presence = $bird->presenceMeta->value;

                    $months = collect(array_map('trim', explode(',', $presence)));

                    foreach($filterMonths as $month) {
                        if ($months->contains($month)) {
                            return true;
                        }
                    }
                });

            $birds = $birds->whereIn('id', $filteredBirdsByPresence->pluck('primary_bird_id'));
        }

        return $birds;
    }

    public function getPresenceConnections($query)
    {
        return $query->with('chronoConnections')->get()->pluck('chronoConnections')
            ->flatten()
            ->filter(function($connection) { 
                $bird = $connection->otherBird;

                if (is_null($bird)) {
                    return;
                }
                
                if ($bird->resource_type_id !== 8) {
                    return;
                }
                
                return $bird->presenceMeta; 
            });
    }

    public function resetAllFilters()
    {
        $this->reset('filterCategoryBirds');
        $this->reset('filterQuery');
        $this->reset('filterMonths');
        $this->reset('filterSeasons');

        $this->emit('bird.index:resetted');
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $this->birds = $this->birdsFiltered->get();
        } else {
            $this->birds = [];
        }

        $this->birdIds = $this->birds 
            ? $this->birds->pluck('id')
            : [];

        $this->emit('bird.index:rendering', $this->birdIds);

        return view('livewire.project.bird.index');
    }
}
