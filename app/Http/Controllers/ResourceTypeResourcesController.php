<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceMeta;
use App\ResourceType;
use Illuminate\Http\Request;

class ResourceTypeResourcesController extends Controller
{
    public function create(Request $request, ResourceType $resourceType)
    {
        $resource = new Resource;
        $resource->definition()->associate($resourceType);
        
        return view('resource-type.resources.create', compact('resourceType', 'resource'));
    }

    public function store(Request $request, ResourceType $resourceType)
    {
        $request->validate([
            'name' => 'required | string | max:255',
            'citation' => 'nullable | max:255',
            'attribute' => 'nullable',
            'newAttribute' => 'nullable'
        ]);
        
        $resource = $resourceType->resources()->create([
            'name' => $request->name,
            'citation' => $request->citation
        ]);
        
        $attributes = collect($request->newAttribute)->filter(function($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->map(function($item, $key) {
            $key = explode('-', $key)[1];

            return [
                'resource_attribute_id' => $key,
                'value' => $item
            ];
        })->toArray();

        $resource->meta()->createMany($attributes);
    
        return redirect()->route('resources.edit', $resource)
            ->with('status', "$resource->name was created!");  
    }

    public function update(Request $request, ResourceType $resourceType, Resource $resource)
    {
        $request->validate([
            'name' => 'required | string | max:255',
            'citation' => 'nullable | max:255',
            'attribute' => 'nullable',
            'newAttribute' => 'nullable'
        ]);
        
        $resource->update($request->except('attribute', 'newAttribute'));

        $attributes = collect($request->attribute)->filter(function($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function($value, $key) use ($resource) {
            $key = explode('-', $key)[1];

            if ($attribute = ResourceMeta::find($key)) {
                $attribute->value = $value;
                $attribute->save();
            } else {
                $attribute = new ResourceMeta;
                $attribute->resource_attribute_id = $key;
                $attribute->value = $value;
    
                $resource->meta()->save($attribute);
            }
           
        });

        $newAttributes = collect($request->newAttribute)->filter(function($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function($value, $key) use ($resource) {
            $key = explode('-', $key)[1];
            $attribute = $resource->meta()->create([
                'resource_attribute_id' => $key,
                'value' => $value
            ]);
        });

    
        return redirect()->route('resources.edit', $resource)
            ->with('status', "$resource->name was updated!");  
    }
}
