<?php

namespace App\Http\Livewire\Project\Bird;

use App\ResourceType;
use Livewire\Component;

class Index extends Component
{
    public $birdDefinition;
    public $birds;
    public $birdIds;
    public $perPage = 18;

    public $filterQuery;
    public $filterOrderable;
    public $filterOrderableDirection = 'asc';
    public $filterCategoryBirds;
    public $filterFilterables;

    public $readyToLoad = false;

    protected $listeners = [
        'bird.filter:query-updated' => 'updatePoemsByQuery',
        'bird.filter:orderable-updated' => 'updatePoemsByOrderable',
        'bird.filter:bird-updated' => 'updatePoemsByBirds',
        'bird.filter:filterable-updated' => 'updatePoemsByFilterables'
    ];

    public function mount()
    {
        $this->birdDefinition = ResourceType::find(19);
        //$this->filterOrderable = $this->birdDefinition->attributes->where('visibility', 1)->first();
    }

    public function render()
    {
        /*if ($this->readyToLoad) {
            $this->birds = $this->birdsFiltered->get();
        } else {
            $this->birds = [];
        }*/

        $this->birds = $this->birdDefinition->resources->take(9);

        $this->birdIds = $this->birds 
            ? $this->birds->pluck('id')
            : [];

        $this->emit('bird.index:rendering', $this->birdIds);

        return view('livewire.project.bird.index');
    }
}
