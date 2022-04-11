<?php

namespace App\Http\Livewire\Project;

use App\Resource;
use Livewire\Component;
use Spatie\MediaLibrary\Models\Media;

class MediaViewer extends Component
{
    public $resource;

    public $media;

    public $medias;

    public function mount(Resource $resource)
    {
        $this->resource = $resource;
        $this->medias = $resource->media;

        $this->setMedia($this->medias->first()->id);
    }

    public function setMedia($media)
    {
        $this->media = $this->medias->firstWhere('id', $media);

        $mediaIndex = $this->medias->pluck('id')->search($media);

        $this->emit('media-viewer:pageChanged', $mediaIndex);
    }

    public function render()
    {
        return view('livewire.project.media-viewer');
    }
}
