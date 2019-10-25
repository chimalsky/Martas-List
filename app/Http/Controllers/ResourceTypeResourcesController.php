<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceType;
use Illuminate\Http\Request;

class ResourceTypeResourcesController extends Controller
{
    public function create(Request $request, ResourceType $resourceType)
    {
        return view('resource-type.resources.create', compact('resourceType'));
    }

    public function store(Request $request, ResourceType $resourceType)
    {
        $request->validate([
            'name' => 'required | string',
            'attribute' => 'nullable'
        ]);
        
        $resource = $resourceType->resources()->create([
            'name' => $request->name
        ]);
        
        $attributes = collect($request->attribute)->map(function($item, $key) {
            return [
                'key' => $key,
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
            'name' => 'required | string',
            'attribute' => 'nullable'
        ]);

        $resource->update($request->except('attribute'));

        $attributes = collect($request->attribute)->filter(function($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function($value, $key) use ($resource) {
            $attribute = $resource->meta()->firstOrNew(['key' => $key]);
            $attribute->value = $value;
            $attribute->save();
        });
    
        return redirect()->route('resources.edit', $resource)
            ->with('status', "$resource->name was updated!");  
    }
}
