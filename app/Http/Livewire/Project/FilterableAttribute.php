<?php

namespace App\Http\Livewire\Project;

use App\ResourceAttribute;
use Livewire\Component;

class FilterableAttribute extends Component
{
    public $attribute;

    public $options;

    public $activeOptions;

    public $expanded;

    protected $casts = [
        'activeOptions' => 'collection'
    ];

    public function mount(ResourceAttribute $attribute, $expanded = false)
    {
        $this->attribute = $attribute;
        $this->options = $attribute->options;
        $this->activeOptions = collect([]);
        $this->expanded = $expanded; 
    }

    public function toggleDropdown()
    {
        $this->expanded = !($this->expanded);
    }

    public function syncOptions($option)
    {
        $options = $this->activeOptions;

        if ($options->contains($option)) {
            $options = $options->reject(function($value) use ($option) {
                return $value == $option;
            });
        } else {
            $options->push($option);
        }

        $this->activeOptions = $options;

        $this->emitUp('filterable-attribute.activeOptions.changed', $this->attribute->id, $this->activeOptions->toArray());
    }

    public function resetOptions()
    {
        $this->activeOptions = collect([]);

        $this->emitUp('filterable-attribute.activeOptions.resetOptions', $this->attribute->id, []);
    }

    public function getIsActiveProperty()
    {
        return $this->activeOptions->count();
    }

    public function render()
    {
        return view('livewire.project.filterable-attribute');
    }
}