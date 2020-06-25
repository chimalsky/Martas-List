<?php

namespace App\Http\Livewire\Resource;

use App\Resource;
use Livewire\Component;

class Header extends Component
{
    public $resource;

    public $name;

    public $citation;

    public $resource_category_id;

    public function mount($resource)
    {
        $this->resource = $resource;


        $this->name = $resource->name;
        $this->citation = ($resource->citation) ? $resource->citation->citation : null;
        $this->resource_category_id = $resource->resource_category_id;
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => 'required | string | min:1 | max:255',
            'citation' => 'sometimes | string | min:1 | max:255',
            'resource_category_id' => 'nullable | exists:resource_categories,id'
        ]);

        if ($field == 'citation') {
            $this->resource->citation->update([
                'citation' => $this->citation
            ]);
        } else {
            $this->resource->$field = $this->$field ? $this->$field : null;
            $this->resource->save();
        }
    }

    public function render()
    {
        return view('livewire.resource.header');
    }
}
