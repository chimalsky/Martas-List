<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResourceType;
use App\ResourceMeta;
use App\ResourceAttribute;

class ResourceTypeAttributeOptionsController extends Controller
{
    public function edit(Request $request, ResourceType $resourceType, ResourceAttribute $attribute) 
    {
        $request->validate([
            'option' => ['required', function($validatingAttribute, $value, $fail) use ($attribute) {
                if (!collect($attribute->options)->contains($value)) {
                    $fail('This is an invalid option for this attribute.');
                }
            }]
        ]);

        $option = $request->option;

        $attributeValues = ResourceMeta::with('resource')
            ->where('resource_attribute_id', $attribute->id)
            ->where('value', $option)->get();
                   
        return view('resource-type.attributes.options.edit', 
            compact('resourceType', 'attribute', 'option', 'attributeValues')
        );
    }

    public function update(Request $request, ResourceType $resourceType, ResourceAttribute $attribute)
    {
        $request->validate([
            'option' => 'required',
            'new_option' => ['required', function($validatingAttribute, $value, $fail) use ($attribute) {
                if (collect($attribute->options)->contains($value)) {
                    $fail('Sorry... the option '. $value . 'already xxists on this attribute');
                }
            }]
        ]);

        $option = $request->option;
        $newOption = $request->new_option;

        dd($newOption);

        $attributeValues = ResourceMeta::where('resource_attribute_id', $attribute->id)
            ->where('value', $option);

        $attributeValues->update([
            'value' => $newOption
        ]);

        $newOptions = collect($attribute->options)->filter(function($o) use ($option) {
            return $o != $option;
        });
        $newOptions->push($newOption);

        $attribute->update([
            'options' => $newOptions->toArray()
        ]);

        return redirect()
            ->route('resource-type.attribute.options.edit', 
                [ 
                    $resourceType,
                    $attribute,
                    'option' => $newOption
                ])
            ->with('status', 'You did it! Trump would be soooo proud!');
    }

    public function destroy(Request $request, ResourceType $resourceType, ResourceAttribute $attribute)
    {
        $request->validate([
            'option' => ['required', function($validatingAttribute, $value, $fail) use ($attribute) {
                if (!collect($attribute->options)->contains($value)) {
                    $fail('This is an invalid option for this attribute.');
                }
            }]
        ]);

        $option = $request->option;
        
        $optionsCollection = collect($attribute->options);
        $index = $optionsCollection->search($option);
        $optionsCollection->pull($index);

        $attribute->update([
            'options' => $optionsCollection->toArray()
        ]);

        return redirect()->route('resource-type.attributes.edit', [$resourceType, $attribute])
            ->with('status', $option." was deleted. However, if there were duplicates, the ordering 
                might have shifted so please double-check.");
    }

    public function sort(Request $request, ResourceType $resourceType, ResourceAttribute $attribute)
    {
        $request->validate([
            'options' => 'required | array',
            'options.*' => 'array'
        ]);

        $attribute->update([
            'options' => $request->options
        ]);

        return redirect()->route('resource-type.attributes.edit', [$resourceType, $attribute])
            ->with('status', "The order of options has been changed!");    
    }
}
