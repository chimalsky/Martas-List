<?php

namespace App\Http\Livewire\Project\Poem;

use App\ResourceType;
use Livewire\Component;

class LoadedIndex extends Component
{
    public $poemDefinition;

    public $poemIds;

    public $perPage;

    public $page;

    protected $casts = [
        'poemIds' => 'collection',
    ];

    public function mount($poemIds, $page, $perPage = 15)
    {
        $this->poemIds = $poemIds;

        $this->poemDefinition = ResourceType::find(3);
        $this->perPage = $perPage;
        $this->page = $page;
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

        return view('livewire.project.poem.loaded-index', compact('poems'));
    }
}
