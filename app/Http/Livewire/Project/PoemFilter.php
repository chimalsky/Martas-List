<?php

namespace App\Http\Livewire\Project;

use App\Resource;
use App\ResourceAttribute;
use App\ResourceType;
use Livewire\Component;

class PoemFilter extends Component
{
    public $definition;

    public $sortedAttribute;

    public $filteredAttributeOptions;

    public $filteredAttributes;

    public $poems;

    public $birds;

    protected $casts = [
        'filteredAttributeOptions' => 'collection',
        'filteredAttributes' => 'collection',
        'poems' => 'collection',
        'birds' => 'collection',
    ];

    protected $updatesQueryString = [
        'sortedAttribute',
        'filteredAttributeOptions',
        'filteredAttributes',
    ];

    public function mount()
    {
        $this->definition = ResourceType::find(3);

        $this->sortedAttribute = request()->query('order');
        $this->filteredAttributeOptions = collect(request()->query('attributeOptions'));
        $this->filteredAttributes = ResourceAttribute::whereIn('id', $this->filteredAttributeOptions->keys())->get();

        $this->poems = collect();

        $this->birds = Resource::where('resource_type_id', 2)
            ->orderBy('name')->get();

        $this->filter();
    }

    public function filter()
    {
        $filteredAttributes = $this->filteredAttributes;

        $poems = Resource::with(['media', 'meta' => function ($query) use ($filteredAttributes) {
            // 84 == first line
            // 149 == needs placeholder image for facs?
            $attributeIds = [84, 149];

            foreach ($filteredAttributes as $a) {
                $attributeIds[] = $a->id;
            }
            $query->whereIn('resource_attribute_id', $attributeIds);
        }])
            ->where('resource_type_id', $this->definition->id);

        if ($filteredAttributes->count()) {
            $filteredAttributeOptions = $this->filteredAttributeOptions;

            foreach ($filteredAttributes as $attribute) {
                $poems = $poems->whereHas('meta', function ($query) use ($attribute, $filteredAttributeOptions) {
                    $query = $query->where('resource_attribute_id', $attribute->id);

                    if ($filteredAttributeOptions->keys()->contains($attribute->id)) {
                        $query = $query->whereIn('value', array_keys($filteredAttributeOptions[$attribute->id]));
                    }

                    return $query;
                });
            }
        }

        $this->poems = $poems->get()->groupBy('queries_meta_value');
    }

    public function inputChanged($attributeId, $option)
    {
    }

    public function resetAttributeProperties()
    {
    }

    public function render()
    {
        return view('project.poems._filter');
    }
}
