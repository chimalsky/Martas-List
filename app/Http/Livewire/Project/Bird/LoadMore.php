<?php

namespace App\Http\Livewire\Project\Bird;

use App\ResourceType;
use Livewire\Component;

class LoadMore extends Component
{
    public $resourceDefinition;

    public $resourceIds;

    public $perPage;
    public $page;

    public $loadMore;

    protected $casts = [
        'resourceIds' => 'collection'
    ];

    protected $listeners = [
        'loadMore',
        'bird.index:rendering' => 'refreshResourceIds'
    ];

    public function mount($resourceIds = [], $page, $perPage = 9)
    {
        $this->resourceIds = $resourceIds;

        $this->resourceDefinition = ResourceType::find(19);
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function refreshResourceIds($resourceIds = [])
    {
        $this->resourceIds = $resourceIds;
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function getResourcesPaginatedProperty()
    {
        return $this->resourceDefinition->resources()->whereIn('id', $this->resourceIds ?? [])->paginate($this->perPage, ['*'], null, $this->page);
    }

    public function getResourcesRemainingProperty()
    {
        return $this->resourcesPaginated->total() - ($this->resourcesPaginated->perPage() * $this->resourcesPaginated->currentPage() - $this->resourcesPaginated->perPage());
    }

    public function render()
    {
        $birds = $this->resourcesPaginated;

        if ($this->loadMore) {
            return view('livewire.project.bird.loaded-index', compact('birds'));
        } else {
            return view('livewire.project.bird.load-more', compact('birds'));
        }
    }
}
