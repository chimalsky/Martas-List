<?php

namespace App\Http\Livewire\Project;

use App\Resource;
use Livewire\Component;

class PoemsList extends Component
{
    protected $poems;

    protected $listeners = ['renderingPoemsIndex' => 'renderPoemsList'];

    public function mount($poems) {
        $this->poems = 'asdf'; //poems ? $poems->paginate(30) : collect([]);
    }

    public function renderPoemsList($poems)
    {
        dd(collect($poems['data'])->mapInto(Resource::class));
        $this->poems = $poems;
    }

    public function getPoemsProperty()
    {
        return $this->poems;
    }

    public function render()
    {
        //dd($this);

        return view('livewire.project.poems-list');
    }
}
