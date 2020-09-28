<?php

namespace App\Http\Livewire\Project\Bird;

use App\ResourceType;
use Livewire\Component;

class Filter extends Component
{
    public $birdDefinition;

    public $birds;
    public $dickinsonsBirds;
    public $activeBirdCategories;

    public $activeBirds;

    public $query;

    protected $listeners = [
        'filterable-attribute:resetted' => 'filterByAttribute',
        'filterable-attribute:activeOptionsUpdated' => 'filterByAttribute',
        'bird.index:resetted' => 'resetAll',
        'activeBirdRemoved' => 'updateSelectedBird'
    ];

    public function mount()
    {
        $this->birdDefinition = ResourceType::find(19);
        $this->birds = $this->birdDefinition->resources;
        $this->dickinsonsBirds = $this->birdDefinition->categories;
        $this->activeBirdCategories = collect([]);
    }

    public function updatedQuery()
    {
        $this->emit('bird.filter:query-updated', $this->query);        
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

        $this->emit('bird.filter:bird-updated', $this->activeBirdCategories);
    }

    public function resetBirds()
    {
        $this->activeBirdCategories = collect([]);
        $this->emit('bird.filter:bird-updated', $this->activeBirdCategories);
    }

    public function resetAll()
    {
        $this->activeBirdCategories = collect([]);
        $this->reset('query');
        //$this->activeFilterables = collect([]);
    }

    public function render()
    {
        return view('livewire.project.bird.filter');
    }
}
