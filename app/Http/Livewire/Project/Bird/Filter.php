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
    
    public function mount()
    {
        $this->birdDefinition = ResourceType::find(19);
        $this->birds = $this->birdDefinition->resources;
        $this->dickinsonsBirds = $this->birdDefinition->categories;
        $this->activeBirdCategories = collect([]);
    }

    public function render()
    {
        return view('livewire.project.bird.filter');
    }
}
