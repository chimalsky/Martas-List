<?php

namespace App\Http\Livewire\Project;

use App\ResourceType;
use Livewire\Component;

class LoadMore extends Component
{
    protected $poems;

    public $poemDefinition;

    public $poemIds;

    public $perPage;

    public $page;

    public $loadMore;

    protected $casts = [
        'poemIds' => 'collection',
    ];

    protected $listeners = [
        'loadMore',
    ];

    public function mount($poemIds, $page, $perPage = 15)
    {
        $this->poemDefinition = ResourceType::find(3);
        $this->perPage = $perPage;
        $this->page = $page + 1;

        if ($poemIds) {
            $this->poems = $this->poemDefinition->resources()->whereIn('id', $poemIds);
            $this->poemIds = $poemIds;
        } else {
            $this->poems = $this->poemDefinition->resources();
            $this->poemIds = $this->poems->pluck('id');
        }
    }

    public function loadMore()
    {
        $this->loadMore = true;

        if ($this->poemIds) {
            $this->poems = $this->poemDefinition->resources()->whereIn('id', $this->poemIds);
        } else {
            $this->poems = $this->poemDefinition->resources();
        }
    }

    public function getPoemsPaginatedProperty()
    {
        return $this->poems->paginate($this->perPage, ['*'], null, $this->page);
    }

    public function getPoemsRemainingProperty()
    {
        return $this->poemsPaginated->total() - ($this->poemsPaginated->perPage() * $this->poemsPaginated->currentPage() - $this->poemsPaginated->perPage());
    }

    public function render()
    {
        $poems = $this->poemsPaginated;

        if ($this->loadMore) {
            return view('livewire.project.poems-list', compact('poems'));
        } else {
            return view('livewire.project.load-more', compact('poems'));
        }
    }
}
