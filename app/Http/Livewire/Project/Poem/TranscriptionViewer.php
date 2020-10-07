<?php

namespace App\Http\Livewire\Project\Poem;

use App\Resource;
use Livewire\Component;
use Spatie\MediaLibrary\Models\Media;

class TranscriptionViewer extends Component
{
    public $poem;
    public $media;
    public $medias;

    public function mount(Resource $poem)
    {
        $this->poem = $poem; 
        $this->medias = $poem->media;

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
        return view('livewire.project.poem.transcription-viewer');
    }
}
