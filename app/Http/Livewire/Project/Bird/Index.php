<?php

namespace App\Http\Livewire\Project\Bird;

use App\ResourceType;
use App\ResourceCategory;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Index extends Component
{
    public $birdDefinition;
    public $birds;
    public $birdIds;
    public $perPage = 9;

    public $filterQuery;
    public $filterOrderable;
    public $filterOrderableDirection = 'asc';
    public $filterCategoryBirds;
    public $filterFilterables;

    public $readyToLoad = false;

    protected $listeners = [
        'bird.filter:query-updated' => 'updateByQuery',
        'bird.filter:orderable-updated' => 'updatePoemsByOrderable',
        'bird.filter:bird-updated' => 'updateByBirds',
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

    public function getPotentialBirdsProperty()
    {
        return $this->birdDefinition->resources();
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

        return $birds;
    }

    public function resetAllFilters()
    {
        $this->reset('filterCategoryBirds');
        $this->reset('filterQuery');

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
