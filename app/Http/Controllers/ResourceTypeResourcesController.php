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
            'attribute' => 'nullable | max:255',
            'attributeCitation' => 'nullable | max:255',
            'newAttribute' => 'nullable',
            'newAttributeCitation' => 'nullable | max:255'
        ]);
        
        $resource->update($request->except('attribute', 'attributeCitation', 'newAttribute', 'newAttributeCitation'));

        $attributes = collect($request->attribute)->filter(function($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function($value, $key) use ($resource) {
            $key = explode('-', $key)[1];

            if ($meta = ResourceMeta::find($key)) {
                $meta->value = $value;
                $meta->save();
            } else {
                $meta = new ResourceMeta;
                $meta->resource_attribute_id = $key;
                $meta->value = $value;
    
                $resource->meta()->save($meta);
            }
           
        });

        $attributeCitations = collect($request->attributeCitation)->filter(function($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function($value, $key) use ($resource) {
            $key = explode('-', $key)[1];

            $meta = ResourceMeta::find($key);
            $meta->update(['citation' => $value]);
        });

        $newCitations = collect($request->newAttributeCitation)->filter(function($value) {
            return $value;
        })->map(function($value, $key) {
            return [ 
                'key' => $key = explode('-', $key)[1],
                'value' => $value 
            ];
        });

        $newAttributes = collect($request->newAttribute)->filter(function($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function($value, $key) use ($resource, $newCitations) {
            $key = explode('-', $key)[1];
            
            $attribute = $resource->meta()->create([
                'resource_attribute_id' => $key,
                'value' => $value
            ]);

            if ($citation = $newCitations->firstWhere('key', $key)) {
                $attribute->citation = $citation['value'];
                $attribute->save();
            }

        });

    
        return redirect()->route('resources.edit', $resource)
            ->with('status', "$resource->name was updated!");  
    }
}
