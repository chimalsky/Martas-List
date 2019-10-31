<?php

namespace App\Http\Controllers;

use App\ResourceType;
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
    public function show(ResourceType $resourceType)
    {
        $resourceType->load('resources');
        return view('resource-types.show', compact('resourceType'));
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
