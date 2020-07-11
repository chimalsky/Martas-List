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

    public $filterables;

    protected $activePoems;

    protected $listeners = ['filterable-attribute.activeOptions.changed' => 'filter'];

    public function mount()
    {
        $this->filterOpened = false;
        $this->poemDefinition = ResourceType::find(3);
        $this->orderables = $this->poemDefinition->attributes->where('visibility', 1);
    
        $this->filterables = $this->orderables->where('options');
    }

    public function hydrate()
    {
        $this->sort();
    }

    public function toggleFilter()
    {
        $this->filterOpened = ($this->filterOpened) ? false : true;
    }

    public function sort($attributeId = null)
    {        
        $this->resetPage();

        if ($attributeId) {
            $this->orderable = ResourceAttribute::find($attributeId);
        } else {
           $this->orderable = $this->orderables->first();
           $attributeId = $this->orderable->id;
        }

        $activePoems = $this->poemDefinition->resources()
            ->with(['meta' => function($query) use ($attributeId) {
                $query->where('resource_attribute_id', $attributeId);
            }, 'media'])
            ->withQueryableMetaValue($attributeId)
            ->orderBy('queryable_meta_value', 'asc');

        $this->activePoems = $activePoems;
    }

    public function filter($attributeId, $optionValues)
    {        
        $this->resetPage();

        $orderableId = $this->orderable->id ?? $this->orderables->first()->id;

        $activePoems = $this->poemDefinition->resources()
            ->whereHas('meta', function ($query) use ($attributeId, $optionValues) {
                $query = $query->where('resource_attribute_id', $attributeId);
        
                $query = $query->whereIn('value', $optionValues);
            })
            ->with(['meta' , 'media'])
            ->withQueryableMetaValue($orderableId)
            ->orderBy('queryable_meta_value', 'asc');

        //$this->activePoems = $this->activePoems->load('media');

        $this->activePoems =  $activePoems;
    }

    public function getPoemsProperty()
    {
        if (!$this->activePoems || !$this->activePoems->exists()) {
            return collect([]);
        }

        return $this->activePoems->paginate(30);
    }

    public function render()
    {
        $poems = ['poems' => $this->poems];
        
        return view('livewire.project.poems-index', $poems);
    }
}
