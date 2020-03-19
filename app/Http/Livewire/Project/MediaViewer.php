<?php

namespace App\Http\Livewire\Project;

use Sp;
use App\Resource;
use Livewire\Component;
use Spatie\MediaLibrary\Models\Media;

class MediaViewer extends Component
{
    public $resource;
    public $media;

    public function mount(Resource $resource)
    {
        $this->resource = $resource; 
    }

    public function setMedia($media)
    {
        $this->media = Media::find($media);
    }

    public function render()
    {
        $resource = $this->resource;
        $media = $this->media ?? $resource->getFirstMedia();

        return view('livewire.project.media-viewer', compact('resource', 'media'));
    }
}
