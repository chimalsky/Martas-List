<?php

namespace App\Http\Livewire;

use App\AttributeOption;
use App\OptionCategory;
use Livewire\Component;

class SortableOptions extends Component
{
    public $category;

    public $options;

    public function mount(OptionCategory $category)
    {
        $this->category = $category;
        $this->options = $category->options;
    }

    public function updateOptionsOrder($elements)
    {
        $elements = collect($elements);

        $options = AttributeOption::whereIn('id', $elements->pluck('value')->toArray())
            ->get();

        AttributeOption::setNewOrder($elements->pluck('value'));

        $this->category = OptionCategory::find($this->category->id);
        $this->options = $this->category->options;
    }

    public function render()
    {
        return view('livewire.sortable-options');
    }
}
