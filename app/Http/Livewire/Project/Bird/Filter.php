<?php

namespace App\Http\Livewire\Project\Bird;

use App\Project\ChronoBird;
use App\ResourceMeta;
use App\ResourceType;
use App\ResourceAttribute;
use Livewire\Component;

class Filter extends Component
{
    public $birdDefinition;

    public $birds;
    public $dickinsonsBirds;
    public $activeBirdCategories;
    public $activeMonths;
    public $activeSeasons;
    public $activeChrono;
    public $activeConservationStates;

    public $activeBirds;

    public $activeChronoScope;

    public $query;
    public $threatQuery;

    public $filterables;

    public $renderCount;

    public $index = 0;

    protected $listeners = [
        'filterable-attribute:resetted' => 'filterByAttribute',
        'filterable-attribute:activeOptionsUpdated' => 'filterByAttribute',
        'bird.index:resetted' => 'resetAll',
        'bird.index:rendering' => 'indexRendering',
        'activeBirdRemoved' => 'updateSelectedBird',
        'activeSeasonRemoved' => 'updateSeason',
        'activeMonthRemoved' => 'updateMonth'
    ];

    public function mount()
    {
        $this->birdDefinition = ResourceType::find(19);
        $this->birds = $this->birdDefinition->resources;
        $this->dickinsonsBirds = $this->birdDefinition->categories;

        $this->activeBirdCategories = collect([]);
        $this->activeMonths = collect([]);
        $this->activeSeasons = collect([]);
        $this->activeChrono = 19;
        $this->activeConservationStates = collect([]);

        $this->activeChronoScope = 'seasons';
    }

    public function updatedQuery()
    {
        $this->emit('bird.filter:query-updated', $this->query);        
    }

    public function updatedThreatQuery()
    {
        $this->emit('bird.filter:threatQuery-updated', $this->threatQuery);        
    }

    public function updatedActiveChronoScope()
    {
        $this->emit('bird.filter:activeChronoScope-updated', $this->activeChronoScope);        
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

    public function updateMonth($month)
    {
        if (! $this->activeMonths->contains($month) ) {
            $this->activeMonths->push(
                $month
            );
        } else {
            $index = $this->activeMonths->search($month);

            $this->activeMonths->splice($index, 1);
        }

        $this->emit('bird.filter:month-updated', $this->activeMonths);
    }

    public function updateSeason($season)
    {
        if (! $this->activeSeasons->contains($season) ) {
            $this->activeSeasons->push(
                $season
            );
        } else {
            $index = $this->activeSeasons->search($season);

            $this->activeSeasons->splice($index, 1);
        }

        $season = $this->activeSeasons->first();

        $this->emit('bird.filter:season-updated', $this->activeSeasons);
    }

    public function updateConservationState($state)
    {
        if (! $this->activeConservationStates->contains($state) ) {
            $this->activeConservationStates->push(
                $state
            );
        } else {
            $index = $this->activeConservationStates->search($state);

            $this->activeConservationStates->splice($index, 1);
        }

        $this->emit('bird.filter:conservation-updated', $this->activeConservationStates);
    }

    public function chronoClicked()
    {
        $this->emit('bird.filter:chrono-updated', $this->activeChrono);
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
        $this->activeMonths = collect([]);
        $this->activeSeasons = collect([]);
        //$this->activeFilterables = collect([]);
    }

    public function indexRendering($resourceIds)
    {
        $this->renderCount = collect($resourceIds)->count();
    }

    public function render()
    {
        return view('livewire.project.bird.filter');
    }
}
