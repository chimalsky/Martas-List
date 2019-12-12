<?php

namespace App\Http\Livewire;

use App\ResourceMeta;
use Livewire\Component;

class ResourceAttribute extends Component
{
    public $metaId;

    public function mount($metaId)
    {
        $this->metaId = $metaId;
    }

    public function getMetaProperty()
    {
        return ResourceMeta::find($this->metaId) ?? null;
    }

    public function render()
    {
        return view('livewire.resource-attribute');
    }

    public function delete()
    {
        $resource = $this->meta->resource;
        $this->meta->delete();

        return redirect()->route('resources.edit', $resource);
    }
}
