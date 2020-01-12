<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceType;
use App\ResourceMeta;
use Illuminate\Http\Request;

class ResourceTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resourceTypes = ResourceType::all();

        return view('resource-types.index', compact('resourceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resource-types.create');
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
            'description' => 'nullable'
        ]);

        $resourceType = ResourceType::create($validated);
        
        return redirect()->route('resource-types.show', $resourceType)
            ->with('status', "A new type of resource -- $resourceType->name -- was created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceType $resourceType, Request $request)
    {
        $enabledAttributes = collect($request->query('attribute'))->keys();

        $reverse = $request->query('reverse') ? 'desc' : 'asc';
        $sortMeta = $request->query('sortMeta') ?? $enabledAttributes[0] ?? null;
        $sortName = $request->query('sortName') ?? null;
        
        $resources = $resourceType->resources()
            ->with(['meta' => function($query) use ($enabledAttributes) {
                return $query->whereIn('resource_attribute_id', $enabledAttributes);
            }]);

        if ($sortMeta) {
            $resources = $resources->addSelect(['queries_meta_value' => function($query) use ($sortMeta) {
                $query->select('value')
                    ->from('resource_metas')
                    ->whereColumn('resource_id', 'resources.id')
                    ->where('resource_attribute_id', $sortMeta)
                    ->latest()->limit(1);
            }])
            ->orderBy('queries_meta_value', $reverse);
        } else {
            $resource = $resources->orderBy('name', $reverse);
        }

        $resources = $resources->get();

        return view('resource-types.show', compact('resourceType', 'enabledAttributes', 'resources'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceType $resourceType)
    {
        return view('resource-types.edit', compact('resourceType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResourceType $resourceType)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $resourceType->update($validated);
        
        return redirect()->route('resource-types.show', $resourceType)
            ->with('status', "An existing type of resource -- $resourceType->name -- was updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceType $resourceType)
    {
        //
    }
}
