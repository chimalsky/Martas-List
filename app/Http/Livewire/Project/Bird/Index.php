<?php

namespace App\Http\Livewire\Project\Bird;

use App\ResourceType;
use App\ResourceCategory;
use App\Project\Bird;
use App\Project\ChronoBird;
use Livewire\Component;
use App\Project\MonthEnum;
use App\Project\SeasonMonthsEnum;
use Illuminate\Support\Facades\Validator;

class Index extends Component
{
    public $birdDefinition;
    public $birds;
    public $birdIds;
    public $chronoBirds;
    public $perPage = 6;

    public $filterQuery;
    public $filterThreatQuery;
    public $filterOrderable;
    public $filterOrderableDirection = 'asc';
    public $filterCategoryBirds;
    public $filterFilterables;
    public $filterMonths;
    public $filterSeasons;
    public $filterChrono;
    public $filterConservationStates;

    public $readyToLoad = false;

    protected $listeners = [
        'bird.filter:query-updated' => 'updateByQuery',
        'bird.filter:threatQuery-updated' => 'updateByThreatQuery',
        'bird.filter:orderable-updated' => 'updatePoemsByOrderable',
        'bird.filter:bird-updated' => 'updateByBirds',
        'bird.filter:month-updated' => 'updateByMonth',
        'bird.filter:season-updated' => 'updateBySeason',
        'bird.filter:chrono-updated' => 'updateByChrono',
        'bird.filter:conservation-updated' => 'updateByConservationState'

    ];

    public function mount()
    {
        $this->birdDefinition = ResourceType::find(19);
        $this->filterChrono = 19;
        
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

    public function updateByThreatQuery($query)
    {
        $validator = Validator::make([
            'query' => $query
        ], [
            'query' => ['required', 'string', 'min:2']
        ]);

        if ($validator->fails()) {
            $this->filterThreatQuery = null;
            return;
        }

        $this->filterThreatQuery = $query;
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

    public function updateByChrono($century)
    {
        $this->filterChrono = $century;
    }

    public function updateByConservationState(array $activeConservationStates)
    {
        $this->filterConservationStates = collect($activeConservationStates);
    }

    public function getPotentialBirdsProperty()
    {
        return new Bird;
    }

    public function getChronoResourceTypeProperty()
    {
        $chronoDict = [
            '19' => ChronoBird::nineteenthCenturyResourceType(),
            '20' => ChronoBird::twentiethCenturyResourceType(),
            '21' => ChronoBird::twentyFirstCenturyResourceType()
        ];

        return $chronoDict[$this->filterChrono];
    }

    public function getBirdsFilteredProperty()
    {
        $birds = $this->potentialBirds;

        if ($this->filterCategoryBirds && $this->filterCategoryBirds->count()) {
            $birds = $birds->whereIn('resource_category_id', $this->filterCategoryBirds->pluck('id'));
        }

        if ($this->filterQuery) {
            $query = $this->filterQuery;
            $birds = $birds->where('name', 'like', "%$query%");
        }

        if ($this->filterThreatQuery) {
            $threatQuery = $this->filterThreatQuery;

            $birds = $birds->whereHas('meta', function ($query) use ($threatQuery) {
                $query = $query->where('resource_attribute_id', 510)
                    ->where('value', 'like', '%'.$threatQuery.'%');
            });
        }

        if (optional($this->filterConservationStates)->count()) {
            $states = $this->filterConservationStates;

            $birds = $birds->whereHas('meta', function ($query) use ($states) {
                $query = $query->where('resource_attribute_id', 509);

                $query->where(function ($q) use ($states) {
                    foreach ($states as $index => $state) {
                        if ($index > 0) {
                            $q->orWhere('value', 'like', '%'.$state.'%');
                        } else {
                            $q->where('value', 'like', '%'.$state.'%');
                        }
                    };
                });
            });
        }

        if (optional($this->filterSeasons)->count()) {
            $presenceBirdsConnections = $this->getPresenceConnections($birds);
            
            $filterSeasons = $this->filterSeasons;

            $filteredBirdsByPresence = $presenceBirdsConnections
                ->filter(function($connection) use ($filterSeasons) {
                    $bird = $connection->otherBird;

                    $presence = $bird->presenceMeta->value;

                    $months = collect(array_map('trim', explode(',', $presence)));

                    foreach ($filterSeasons as $season) {
                        foreach (SeasonMonthsEnum::getConstant($season) as $month) {
                            if ($months->contains($month)) {
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

                    foreach ($filterMonths as $month) {
                        $month = MonthEnum::getConstant($month);

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
        $chronoResourceType = $this->chronoResourceType;

        return $query->with('chronoConnections')->get()->pluck('chronoConnections')
            ->flatten()
            ->filter(function($connection) use ($chronoResourceType) { 
                $bird = $connection->otherBird;

                if (is_null($bird)) {
                    return;
                }
                
                if ($bird->resource_type_id !== $chronoResourceType) {
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
