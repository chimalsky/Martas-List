<?php

namespace App\Http\Livewire\Resource;

use App\Resource;
use Livewire\Component;

class Body extends Component
{
    public $resource;

    public $definition;

    public $attributes;

    public $metas;

    public function mount(Resource $resource)
    {
        $this->resource = $resource;
        $this->definition = $resource->definition;
        $this->attributes = $this->definition->attributes;

        $this->metas = $this->resource->meta;
    }

    public function emitChange($metaId, $value)
    {
    }

    public function render()
    {
        return view('livewire.resource.body');
    }
}
