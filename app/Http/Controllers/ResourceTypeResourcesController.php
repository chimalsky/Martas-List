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
        $this->authorize('update', $resourceType);
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
}
