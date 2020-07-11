<?php

namespace App\Http\Livewire\Project;

use App\ResourceAttribute;
use Livewire\Component;

class FilterableAttribute extends Component
{
    public $attribute;

    public $options;

    public $activeOptions;

    public $expanded = false;

    public function mount(ResourceAttribute $attribute)
    {
        $this->attribute = $attribute;
        $this->options = $attribute->options;
    }

    public function toggleDropdown()
    {
        $this->expanded = !($this->expanded);
    }

    public function syncOptions($option)
    {
        $options = collect($this->activeOptions);

        if ($options->contains($option)) {
            $options = $options->reject(function($value) use ($option) {
                return $value == $option;
            });
        } else {
            $options->push($option);
        }

        $this->activeOptions = $options->toArray();

        $this->emitUp('filterable-attribute.activeOptions.changed', $this->attribute->id, $this->activeOptions);
    }

    public function render()
    {
        return view('livewire.project.filterable-attribute');
    }
}
