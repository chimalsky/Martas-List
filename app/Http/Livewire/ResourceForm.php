<?php

namespace App\Http\Livewire;

use App\Resource;
use Livewire\Component;

class ResourceForm extends Component
{
    public $resource;

    public function mount($resource)
    {
        $this->resource = $resource;
    }

    public function deleteMeta($metaId)
    {
        $meta = $this->resource->meta()->where('id', $metaId)->first();
        $meta->delete();
        $this->resource->load('meta');

        $message = $meta->name.' was deleted.';
        $eventLogView = view('event.show', compact('message'));
        $this->emit('deleteMeta', $eventLogView->render());

        //return view('livewire.resource-form', $this->resource);
    }

    public function render()
    {
        $resource = $this->resource;

        return view('livewire.resource-form', compact('resource'));
    }
}
