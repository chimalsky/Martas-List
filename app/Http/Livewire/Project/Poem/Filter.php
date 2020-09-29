<?php

namespace App\Http\Livewire\Project\Poem;

use App\ResourceType;
use Livewire\Component;

class Filter extends Component
{
    public $poemDefinition;
    public $birdDefinition;

    public $birds;
    public $dickinsonsBirds;
    public $activeBirdCategories;

    public $query;

    public $orderables;
    public $orderable;

    public $filterables;
    public $activeFilterables;

    public $renderCount;

    protected $rules = [
    ];

    protected $listeners = [
        'filterable-attribute:resetted' => 'filterByAttribute',
        'filterable-attribute:activeOptionsUpdated' => 'filterByAttribute',
        'poem.index:resetted' => 'resetAll',
        'poem.index:rendering' => 'indexRendering',
        'activeBirdRemoved' => 'updateSelectedBird'
    ];

    public function mount()
    {
        $this->poemDefinition = ResourceType::find(3);
        $this->birdDefinition = ResourceType::find(19);

        $this->birds = $this->birdDefinition->resources;
        $this->dickinsonsBirds = $this->birdDefinition->categories;
        $this->activeBirdCategories = collect([]);

        $this->orderables = $this->poemDefinition->attributes->where('visibility', 1);
        $this->orderable = $this->orderables->first()->id ?? null;

        $this->filterables = $this->orderables->where('options');
        $this->activeFilterables = collect([]);
    }

    public function updatedQuery()
    {
        $this->emit('poem.filter:query-updated', $this->query);        
    }

    public function orderableClicked()
    {
        $this->emit('poem.filter:orderable-updated', $this->orderable);
    }

    public function filterByAttribute($attributeId, $optionValues)
    {        
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

        $this->emit('poem.filter:filterable-updated', $this->activeFilterables);
    }

    public function updateSelectedBird($birdId)
    {
        if (! $this->activeBirdCategories->contains($birdId) ) {
            $this->activeBirdCategories->push(
                $birdId
            );
        } else {
            $index = $this->activeBirdCategories->search($birdId);

            $this->activeBirdCategories->splice($index, 1);
        }

        $this->emit('poem.filter:bird-updated', $this->activeBirdCategories);
    }

    public function resetAll()
    {
        $this->activeBirdCategories = collect([]);
        $this->reset('query');
        $this->activeFilterables = collect([]);
    }

    public function resetBirds()
    {
        $this->activeBirdCategories = collect([]);
        $this->emit('poem.filter:bird-updated', $this->activeBirdCategories);
    }

    public function indexRendering($resourceIds)
    {
        $this->renderCount = collect($resourceIds)->count();
    }

    public function render()
    {
        return view('livewire.project.poem.filter');
    }
}
