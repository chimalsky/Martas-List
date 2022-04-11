<?php

namespace App\Http\Livewire\Project;

use App\Resource;
use App\ResourceType;
use Livewire\Component;

class PoemsList extends Component
{
    protected $poems;

    public $poemDefinition;

    public $poemIds = [];

    public $perPage;

    public $page;

    protected $listeners = [
        'filterUpdated',
    ];

    protected $casts = [
        'poemIds' => 'collection',
    ];

    public function mount($poemIds = null, $perPage = 18, $page = 1)
    {
        $this->poemDefinition = ResourceType::find(3);
        $this->perPage = $perPage;
        $this->page = $page;

        if ($poemIds) {
            $this->poems = $this->poemDefinition->resources()->whereIn('id', $poemIds);
            $this->poemIds = collect($poemIds);
        } else {
            $this->poems = $this->poemDefinition->resources();
            $this->poemIds = $this->poems->pluck('id');
        }
    }

    public function filterUpdated($poemIds)
    {
        $this->poems = $this->poemDefinition->resources()->whereIn('id', $poemIds);
        $this->poemIds = collect($poemIds);
    }

    public function getPoemsPaginatedProperty()
    {
        return $this->poems->paginate($this->perPage, ['*'], null, $this->page);
    }

    public function getPoemIdsProperty()
    {
        return $this->poemIds;
    }

    public function render()
    {
        $poems = $this->poemsPaginated;

        if (! $poems->hasMorePages()) {
            $this->emit('poems-list.end', $this->page);
        } else {
            $this->emit('poems-list.continues', $this->page);
        }

        return view('livewire.project.poems-list', compact('poems'));
    }
}
