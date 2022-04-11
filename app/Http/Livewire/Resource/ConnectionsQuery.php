<?php

namespace App\Http\Livewire\Resource;

use App\Resource;
use App\ResourceType;
use Livewire\Component;

class ConnectionsQuery extends Component
{
    public $resource;

    public $queryable;

    public $query;

    public $externalResources;

    public function mount(Resource $resource, $queryable = null)
    {
        $this->resource = $resource;
        $this->queryable = $queryable
            ? collect($queryable)
            : ResourceType::whereIn('id', $resource->definition->connections->pluck('key'))->get();

        $this->externalResources = [];
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'query' => 'string',
        ]);

        if (strlen($this->query) === 0) {
            $this->externalResources = null;

            return;
        }

        $this->externalResources = Resource::whereIn('resource_type_id', $this->queryable->pluck('id'))
            ->where('name', 'like', '%'.$this->query.'%')
            ->get();
    }

    public function updateConnection($otherResourceId)
    {
        $otherResource = Resource::find($otherResourceId);

        $this->resource->syncConnectionWithResource($otherResource);

        $this->resource = Resource::find($this->resource->id);
    }

    public function clearQuery()
    {
        $this->query = '';
        $this->externalResources = null;
    }

    public function render()
    {
        return view('livewire.resource.connections-query');
    }
}
