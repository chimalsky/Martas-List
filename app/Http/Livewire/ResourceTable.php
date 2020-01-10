<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ResourceTable extends Component
{
    use WithPagination;

    public $perPage = 30;
    public $sortField;
    public $sortAsc = true;
    public $attributes = [];
    public $search = '';

    public function filter()
    {
        $this->attributes = [1,2];
    }

    public function render()
    {
        $resourceType = \App\ResourceType::find(2);
        $resources = $resourceType->resources()
            ->paginate($this->perPage); 

        return view('livewire.resource-table', compact('resourceType', 'resources'));
    }
}
