<?php

namespace App\Http\Livewire\Project;

use App\ResourceType;
use App\ResourceMeta;
use App\ResourceAttribute;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class PoemsIndex extends Component
{
    use WithPagination;

    public $filterOpened;
    public $poemDefinition;

    public $orderables;
    public $orderable;

    protected $activePoems;

    public function mount()
    {
        $this->filterOpened = false;
        $this->poemDefinition = ResourceType::find(3);
        $this->orderables = $this->poemDefinition->attributes->where('visibility', 1);

        $this->activePoems = $this->poemDefinition->resources()->take(10);
    }

    public function sort($attributeId)
    {
        $this->orderable = ResourceAttribute::find($attributeId);
        $orderableId = $this->orderable->id;

        $this->activePoems = $this->poemDefinition->resources()
            ->with(['meta' => function($query) use ($orderableId) {
                $query->where('resource_attribute_id', $orderableId);
            }])
            ->withQueryableMetaValue($orderableId)
            ->orderBy('queryable_meta_value', 'asc');

        //$this->activePoems = $this->activePoems->load('media');

        $this->resetPage();
    }

    public function filter($attributeId, $value)
    {

    }

    public function render()
    {
        //dd($this->activePoems);
        $activePoems = $this->activePoems->paginate(30);
        return view('livewire.project.poems-index', compact('activePoems'));
    }
}
