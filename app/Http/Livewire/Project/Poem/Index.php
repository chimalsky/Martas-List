<?php

namespace App\Http\Livewire\Project\Poem;

use App\ResourceType;
use App\ResourceCategory;
use App\ResourceAttribute;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Index extends Component
{
    public $poemDefinition;
    public $poems;
    public $perPage = 12;
    public $titleMeta = 84;

    public $filterQuery;
    public $filterOrderable;
    public $filterOrderableDirection = 'asc';
    public $filterCategoryBirds;
    public $readyToLoad = false;

    protected $listeners = [
        'poem.filter:query-updated' => 'updatePoemsByQuery',
        'poem.filter:orderable-updated' => 'updatePoemsByOrderable',
        'poem.filter:bird-updated' => 'updatePoemsByBirds'
    ];

    public function mount()
    {
        $this->poemDefinition = ResourceType::find(3);
        $this->filterOrderable = $this->poemDefinition->attributes->where('visibility', 1)->first();
    }

    public function loadPoems()
    {
        $this->readyToLoad = true;
    }

    public function resetPoems()
    {
        $this->poems = $this->potentialPoems->take($this->perPage)->get();
    }

    public function getPotentialPoemsProperty()
    {
        return $this->poemDefinition->resources()
            ->with('transcription');
    }

    public function getPoemsFilteredProperty()
    {
        $poems = $this->potentialPoems;

        if ($this->filterCategoryBirds && $this->filterCategoryBirds->count()) {
            $connectedPoemsIds = $this->filterCategoryBirds->pluck('connections')->flatten()->pluck('id');
            $poems = $this->potentialPoems->whereIn('id', $connectedPoemsIds);
        }

        if ($this->filterQuery) {
            $query = $this->filterQuery;
            $poems = $poems->whereHas('transcription', function($transcriptionQuery) use ($query) {
                $transcriptionQuery->where('value', 'like', "%$query%");
            });
        }

        $poems = $poems->withHeadlineValue($this->titleMeta)
            ->withQueryableMetaValue($this->filterOrderable->id)
            ->orderBy('id', $this->filterOrderableDirection);

        return $poems;
    }

    public function getPoemsPaginatedProperty()
    {
        return $this->poems->paginate($this->perPage);
    }

    public function getPoemIdsProperty()
    {
        return $this->poems->pluck('id');
    }

    public function updatePoemsByQuery(string $query)
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

        /*
        $this->poems = $this->potentialPoems
            ->whereHas('transcription', function($transcriptionQuery) use ($query) {
                $transcriptionQuery->where('value', 'like', "%$query%");
            })
            ->get();
        */
    }

    public function updatePoemsByOrderable($orderableId)
    {
        if ($this->filterOrderable) {
            if ($this->filterOrderable->id == $orderableId) {
                $this->filterOrderableDirection = ('asc' == $this->filterOrderableDirection)
                    ? 'desc'
                    : 'asc';
            } 
        }
        
        $this->filterOrderable = ResourceAttribute::Find($orderableId);
    }
    
    public function updatePoemsByBirds(array $activeBirds)
    {
        $validator = Validator::make([
            'query' => $activeBirds
        ], [
            'query' => ['required', 'array']
        ]);

        if ($validator->fails()) {
        }

        // TODO : restrict CategoryConnections to resource_types
        $activeBirdCategories = ResourceCategory::whereIn('id', $activeBirds)->get();

        //$connectedPoemsIds = $activeBirdCategories->pluck('connections')->flatten()->pluck('id');

        //$this->poems = $this->potentialPoems->whereIn('id', $connectedPoemsIds);

        $this->filterCategoryBirds = $activeBirdCategories;
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $this->poems = $this->poemsFiltered->get();
        } else {
            $this->poems = [];
        }

        return view('livewire.project.poem.index');
    }
}
