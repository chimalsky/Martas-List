<?php

namespace App\Http\Livewire\Resource;

use App\Resource;
use Livewire\Component;

class Body extends Component
{
    public $resource;

    public $definition;
    public $attributes;

    public function mount(Resource $resource)
    {
        $this->resource = $resource;
        $this->definition = $resource->definition;
        $this->attributes = $this->definition->attributes;

    }

    public function emitChange()
    {
        dd('hi');
    }

    public function render()
    {
        return view('livewire.resource.body');
    }
}
