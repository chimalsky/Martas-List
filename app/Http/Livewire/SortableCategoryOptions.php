<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SortableCategoryOptions extends Component
{
    public $attribute; 

    public $categories;

    public $newCategory;

    public function mount($categories)
    {
        $this->categories = $categories->load('options');
        // TODO fix this and then deploy $this->attribute = $categories->first()->attribute;
    }

    public function updateCategoryOrder($foo)
    {
        dd($foo);
    }

    public function updateOptionOrder($elements)
    {
        $elements = collect($elements);

        dd($elements, $foo);

        $options = AttributeOption::whereIn('id', $elements->pluck('value')->toArray())
            ->get();

        AttributeOption::setNewOrder($elements->pluck('value'));

        $this->category = OptionCategory::find($this->category->id);
        $this->options = $this->category->options;
    }

    public function addCategory()
    {
        $this->validate([
            'newCategory' => ['required', 'min:0',  'max:255', function ($attribute, $value, $fail) {
                if ($this->categories->pluck('name')->contains($value)) {
                    $fail($attribute.' already exists.');
                }
            },
        ]]);

        $this->attribute->categories()->create([
            'name' => $this->newCategory
        ]);

        $this->categories = $this->attribute->categories;

        $this->newCategory = '';
    }

    public function addOption($categoryId, $value)
    {
        $category = $this->categories->find($categoryId);
      

        $category->options()->create([
            'value' => $value,
            'attribute_id' => $this->attribute->id
        ]);


    }

    public function render()
    {
        return view('livewire.sortable-category-options');
    }
}
