<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceMeta;
use App\ResourceType;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = ResourceType::find($request->query('type')) ?? ResourceType::first();

        $resources = $type->resources()->get();

        if ($request->wantsJson()) {
            return view('resources.list', compact('resources'));
        }

        return view('resources.index', compact('resources', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'resource_type_id' => 'exists:resource_types,id',
        ]);

        $resource = Resource::create($validated);

        return redirect()->route('resources.edit', $resource)
            ->with('status', "$resource->name was created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        $resource->load(['meta.citations', 'definition']);

        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'name' => 'required | string | max:255',
            'citation' => 'nullable | max:255',
            'resource_category_id' => 'nullable | exists:resource_categories,id',
            'attribute' => 'nullable | max:255',
            'attributeCitation' => 'nullable | max:255',
            'newAttribute' => 'nullable',
            'newAttributeCitation' => 'nullable | max:255',
        ]);

        $resource->update($request->except('attribute', 'attributeCitation', 'newAttribute', 'newAttributeCitation'));

        $attributes = collect($request->attribute)->filter(function ($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function ($value, $key) use ($resource) {
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

        $attributeCitations = collect($request->attributeCitation)->filter(function ($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function ($value, $key) use ($resource) {
            $key = explode('-', $key)[1];

            $meta = ResourceMeta::find($key);
            $meta->update(['citation' => $value]);
        });

        $newCitations = collect($request->newAttributeCitation)->filter(function ($value) {
            return $value;
        })->map(function ($value, $key) {
            return [
                'key' => $key = explode('-', $key)[1],
                'value' => $value,
            ];
        });

        $newAttributes = collect($request->newAttribute)->filter(function ($value, $key) {
            // TODO handle the null update value more resiliently
            return $value;
        })->each(function ($value, $key) use ($resource, $newCitations) {
            $key = explode('-', $key)[1];

            $attribute = $resource->meta()->create([
                'resource_attribute_id' => $key,
                'value' => $value,
            ]);

            if ($citation = $newCitations->firstWhere('key', $key)) {
                $attribute->citation = $citation['value'];
                $attribute->save();
            }
        });

        return redirect()->route('resources.edit', $resource)
            ->with('status', "$resource->name was updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resource-types.show', $resource->definition)
            ->with('status', "Resource ($resource->name) was deleted! RIP the old...");
    }
}
