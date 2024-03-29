<?php

namespace App\Http\Livewire\Project\Poem;

use App\ResourceAttribute;
use App\ResourceType;
use Livewire\Component;

class LoadMore extends Component
{
    public $poemDefinition;

    public $poemIds;

    public $perPage;

    public $page;

    public $loadMore;

    public $filterOrderable;

    public $filterOrderableDirection;

    public $orderablesAndPoems;

    protected $casts = [
        'poemIds' => 'collection',
    ];

    protected $listeners = [
        'loadMore',
        'poem.index:rendering' => 'refreshPoemIds',
        'poem.filter:orderable-updated' => 'orderableUpdated',
    ];

    public function mount($poemIds, $page, $perPage = 15)
    {
        $this->poemIds = $poemIds;

        $this->poemDefinition = ResourceType::find(3);
        $this->perPage = $perPage;
        $this->page = $page;

        // 84 = first-line resource-attribute id
        $this->filterOrderable = $this->poemDefinition->attributes->firstWhere('id', 84);
        $this->filterOrderableDirection = 'asc';
    }

    public function refreshPoemIds($poemIds = [])
    {
        $this->poemIds = $poemIds;
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function orderableUpdated($orderableId, $orderableDirection)
    {
        $this->filterOrderable = ResourceAttribute::find($orderableId);
        $this->filterOrderableDirection = $orderableDirection;
    }

    public function getPoemsPaginatedProperty()
    {
        return $this->poemDefinition->resources()
            ->withQueryableMetaValue($this->filterOrderable->id)
            ->whereIn('id', $this->poemIds ?? [])
            ->orderBy('queryable_meta_value', $this->filterOrderableDirection)
            ->paginate($this->perPage, ['*'], null, $this->page);
    }

    public function getPoemsRemainingProperty()
    {
        return $this->poemsPaginated->total()
            - ($this->poemsPaginated->perPage()
            * $this->poemsPaginated->currentPage() - $this->poemsPaginated->perPage());
    }

    public function render()
    {
        $poems = $this->poemsPaginated;

        /*$this->orderablesAndPoems = $this->poemDefinition->resources()
            ->withQueryableMetaValue($this->filterOrderable->id)
            ->whereIn('id', $this->poemIds)
            ->get();*/

        /*$this->orderablesAndPoems = collect($poems->items())
            ->groupBy('queryable_meta_value')
            ->filter(function($group) {
                return $group->count();
            });*/

        if ($this->loadMore) {
            return view('livewire.project.poem.loaded-index', compact('poems'));
        } else {
            return view('livewire.project.poem.load-more', compact('poems'));
        }
    }
}
