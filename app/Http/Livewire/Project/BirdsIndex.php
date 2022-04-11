<?php

namespace App\Http\Livewire\Project;

use App\ResourceType;
use Livewire\Component;

class BirdsIndex extends Component
{
    public $birdDefinition;

    public $birds;

    public $dickinsonsBirds;

    public $activeBirdCategories;

    public $activeBirds;

    public $query;

    protected $casts = [
        'activeBirdCategories' => 'collection',
    ];

    public function mount()
    {
        $this->birdDefinition = ResourceType::find(19);
        $this->birds = $this->birdDefinition->resources;
        $this->dickinsonsBirds = $this->birdDefinition->categories;
        $this->activeBirdCategories = collect([]);

        $this->activeBirds = $this->birds->take(12);
    }

    public function filterByBird($birdId)
    {
        if (! $this->activeBirdCategories->contains($birdId)) {
            $this->activeBirdCategories->push(
                $birdId
            );
        } else {
            $index = $this->activeBirdCategories->search($birdId);

            $this->activeBirdCategories->splice($index, 1);
        }
    }

    public function filter()
    {
        if ($this->activeBirdCategories && $this->activeBirdCategories->count()) {
            $this->activeBirds = $this->birds->whereIn('resource_category_id', $this->activeBirdCategories);
        }
    }

    public function render()
    {
        $this->filter();

        return view('livewire.project.birds-index');
    }
}
