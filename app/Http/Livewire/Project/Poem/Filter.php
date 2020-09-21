<?php

namespace App\Http\Livewire\Project\Poem;

use App\ResourceType;
use Livewire\Component;

class Filter extends Component
{
    public $query;

    public $poemDefinition;
    public $birdDefinition;

    public $birds;
    public $dickinsonsBirds;
    public $selectedBirds;
    public $activeBirdCategories;

    public $orderables;
    public $orderable;

    protected $rules = [
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
    }

    public function updatedQuery()
    {
        $this->emit('poem.filter:query-updated', $this->query);        
    }

    public function orderableClicked()
    {
        $this->emit('poem.filter:orderable-updated', $this->orderable);
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

    public function render()
    {
        return view('livewire.project.poem.filter');
    }
}
