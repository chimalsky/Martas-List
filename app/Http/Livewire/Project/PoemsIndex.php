<?php

namespace App\Http\Livewire\Project;

use App\ResourceType;
use App\ResourceMeta;
use App\ResourceAttribute;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class PoemsIndex extends Component
{
    use WithPagination;

    public $query;

    public $filterOpened;
    public $poemDefinition;
    public $birdDefinition;

    public $orderables;
    public $orderable;
    public $orderDirection = 'asc';

    public $filterables;
    public $activeFilterables = [];

    public $birds;
    public $dickinsonsBirds;
    public $activeBirds = [];

    protected $activePoems;

    protected $casts = [
        'activeFilterables' => 'collection',
        'activeBirds' => 'collection'
    ];

    protected $listeners = [
        'filterable-attribute.activeOptions.changed' => 'filterByAttribute',
        'filterable-attribute.activeOptions.resetOptions' => 'filterByAttribute',
    ];

    public function mount()
    {
        $this->filterOpened = false;
        $this->poemDefinition = ResourceType::find(3);
        $this->birdDefinition = ResourceType::find(2);

        $this->orderables = $this->poemDefinition->attributes->where('visibility', 1);
        //$this->orderable = $this->orderables->first()->id ?? null;
    
        $this->filterables = $this->orderables->where('options');
        $this->activeFilterables = collect([]);

        $this->birds = ResourceType::find(2)->resources;
        $this->dickinsonsBirds = $this->birdDefinition->categories;
        $this->activeBirds = collect([]);
    }

    public function hydrate()
    {
        $this->sort();
        $this->filter();
    }

    public function toggleFilter()
    {
        $this->filterOpened = ($this->filterOpened) ? false : true;
    }

    public function sort($attributeId = null)
    {        
        if ($attributeId) {            
            if ($this->orderable == $attributeId) {
                $this->toggleOrderDirection();
            } else {
                $this->orderable = ResourceAttribute::find($attributeId)->id;
            }
        } 

        $activePoems = $this->poemDefinition->resources();
           // ->withQueryableMetaValue($attributeId);

        $this->activePoems = $activePoems;
        $this->filter();
    }

    public function filter()
    {
        $orderableId = $this->orderable ?? $this->orderables->first()->id;

        $activePoems = $this->poemDefinition->resources();

        if ($this->activeBirds && $this->activeBirds->count()) {
            $activePoems = $activePoems->whereIn('id', $this->birdConnectedPoemsIds);
        }

        foreach ($this->activeFilterables as $filterable) {
            $activePoems = $activePoems->whereHas('meta', function ($query) use ($filterable) {
                $query = $query->where('resource_attribute_id', $filterable['id']);

                if ($filterable['activeValues']) {
                    $query = $query->whereIn('value', $filterable['activeValues']);
                }
            });
        }

        $this->activePoems =  $activePoems;
    }

    public function filterByBird($birdId)
    {       
        if (! $this->activeBirds->contains($birdId) ) {
            $this->activeBirds->push(
                $birdId
            );
        } else {
            $index = $this->activeBirds->search($birdId);

            $this->activeBirds->splice($index, 1);
        }

        $this->filter();
    }

    public function filterByAttribute($attributeId, $optionValues)
    {        
        $this->resetPage();

        if (! $this->activeFilterables->where('id', $attributeId)->count() ) {
            $this->activeFilterables->push(
                [ 
                    'id' => $attributeId,
                    'activeValues' => $optionValues
                ]
            );
        } else {
            $index = $this->activeFilterables->search(function($item, $key) use ($attributeId) {
                return $item['id'] == $attributeId;
            });

            if (count($optionValues)) {
                $this->activeFilterables[$index] = [
                    'id' => $attributeId,
                    'activeValues' => $optionValues
                ];
            } else {
                $this->activeFilterables->splice($index, 1);
            }
        }

        $this->filter();
    }

    public function toggleOrderDirection()
    {
        $this->orderDirection = ($this->orderDirection === 'asc') ? 'desc' : 'asc';
    }

    public function getPoemsProperty()
    {
        $query = $this->query;

        if (!$this->activePoems || !$this->activePoems->exists()) {
            if (!$query) {
                return collect([]);
            }
            $this->activePoems = $this->poemDefinition->resources();
        }
        
        if ($query) {
            $this->activePoems = $this->activePoems
                ->with('transcription')
                ->whereHas('transcription', function($transcriptionQuery) use ($query) {
                    $transcriptionQuery->where('value', 'like', "%$query%");
                });
        }

        $this->activePoems = $this->activePoems
            ->withHeadlineValue($this->orderables->First()->id)
            ->withQueryableMetaValue($this->orderable)
            ->with(['meta', 'media'])
            ->orderBy('queryable_meta_value', $this->orderDirection);

        return $this->activePoems->paginate(30);
    }

    public function getBirdConnectedPoemsIdsProperty()
    {
        //$birds = $this->birdDefinition->resources->whereIn('id', $this->activeBirds->toArray());
        $birds = $this->birdDefinition->resources->whereIn('resource_category_id', $this->activeBirds->toArray());

        return $birds->map(function($bird) {
            return $bird->connectedResourcesIds;
        }) ->flatten()
            ->unique()
            ->toArray();
    }

    public function getIsCuratingProperty()
    {
        if ($this->query) {
            return true;
        }

        if (! $this->query ) {
            return $this->activeFilterables->count() 
                || $this->activeBirds->count()
                || $this->orderable
                || $this->activePoems;
        }

    }

    public function resetBirds()
    {
        $this->activeBirds = collect([]);
    }

    public function resetAll()
    {
        $this->orderable = null;
        $this->activeFilterables = collect([]);
        $this->resetBirds();
        $this->activePoems = null;
        $this->query = null;
    }

    public function render()
    {
        $poems = ['poems' => $this->poems];
        
        return view('livewire.project.poems-index', $poems);
    }
}
