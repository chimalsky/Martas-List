<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;

class TestThing extends Component
{
    public $attribute;

    public function mount($attribute) {
        $this->attribute = $attribute;
    }

    public function render()
    {
        return view('livewire.project.test-thing');
    }
}
