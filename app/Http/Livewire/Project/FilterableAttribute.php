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
        'activeOptions' => 'collection',
    ];

    protected $listeners = [
        'filterCleared',
        'activeAttributeRemoved',
        'poem.index:resetted' => 'filterCleared',
        'poem.filter:resetted' => 'filterCleared',
    ];

    public function mount(ResourceAttribute $attribute, $expanded = false)
    {
        $this->attribute = $attribute;
        $this->options = $attribute->options;
        $this->expanded = $expanded;
    }

    public function toggleDropdown()
    {
        $this->expanded = ! ($this->expanded);
    }

    public function syncOptions($option)
    {
        $options = collect($this->activeOptions);

        if ($options->contains($option)) {
            $options = $options->reject(function ($value) use ($option) {
                return $value == $option;
            });
        } else {
            $options->push($option);
        }

        $this->activeOptions = $options;

        $this->emitUp('filterable-attribute:activeOptionsUpdated', $this->attribute->id, $this->activeOptions->toArray());

        //$this->emitUp('filterable-attribute.activeOptions.changed', $this->attribute->id, $this->activeOptions->toArray());
    }

    public function resetOptions()
    {
        $this->filterCleared();

        $this->emitUp('filterable-attribute:resetted', $this->attribute->id, []);

        //$this->emitUp('filterable-attribute.activeOptions.resetOptions', $this->attribute->id, []);
    }

    public function filterCleared()
    {
        $this->activeOptions = collect([]);
    }

    public function getIsActiveProperty()
    {
        return collect($this->activeOptions)->count();
    }

    public function isActive($option)
    {
        return collect($this->activeOptions)->contains($option);
    }

    public function activeAttributeRemoved($attributeId, $value)
    {
        if ($attributeId == $this->attribute->id) {
            $options = $this->activeOptions->reject(function ($activeOption) use ($value) {
                return $activeOption == $value;
            });

            $this->activeOptions = $options;

            $this->emitUp('filterable-attribute:activeOptionsUpdated', $this->attribute->id, $this->activeOptions->toArray());
        }
    }

    public function render()
    {
        return view('livewire.project.filterable-attribute');
    }
}
