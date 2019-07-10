<?php

namespace App\Http\Controllers;

use App\Resource;
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
        $type = ResourceType::find($request->query('type'));

        $resources = $type->resources;

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
            'resource_type_id' => 'exists:resource_types,id'
        ]);

        $resource = Resource::create($validated);
        
        return redirect()->route('resource-types.edit', ['resource_type' => $resource->definition->id])
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
        
        return view('resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'name' => 'required',
            'resource_type_id' => 'exists:resource_types,id'
        ]);

        $resource->update($validated);
        
        return redirect()->route('resource-types.edit', ['resource_type' => $resource->definition->id]) 
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
        //
    }
}
