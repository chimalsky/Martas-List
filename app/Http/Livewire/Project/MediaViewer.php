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
        $this->media = $resource->getFirstMedia();
    }

    public function setMedia($media)
    {
        $this->media = Media::find($media);
    }

    public function render()
    {
        return view('livewire.project.media-viewer');
    }
}
