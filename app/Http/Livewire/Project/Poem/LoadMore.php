<?php

namespace App\Http\Livewire\Project\Poem;

use App\ResourceType;
use Livewire\Component;

class LoadMore extends Component
{
    public $poemDefinition;

    public $poemIds;

    public $perPage;
    public $page;

    public $loadMore;

    protected $casts = [
        'poemIds' => 'collection'
    ];

    protected $listeners = [
        'loadMore'
    ];

    public function mount($poemIds = [], $page, $perPage = 15)
    {
        $this->poemIds = $poemIds;

        $this->poemDefinition = ResourceType::find(3);
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function getPoemsPaginatedProperty()
    {
        return $this->poemDefinition->resources()->whereIn('id', $this->poemIds ?? [])->paginate($this->perPage, ['*'], null, $this->page);
    }

    public function getPoemsRemainingProperty()
    {
        return $this->poemsPaginated->total() - ($this->poemsPaginated->perPage() * $this->poemsPaginated->currentPage() - $this->poemsPaginated->perPage());
    }


    public function render()
    {
        $poems = $this->poemsPaginated;

        if ($this->loadMore) {
            return view('livewire.project.poem.loaded-index', compact('poems'));
        } else {
            return view('livewire.project.poem.load-more', compact('poems'));
        }
    }
}
