<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Resource;
use App\ResourceType;
use Illuminate\Http\Request;

class ResourceConnectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Resource   $resource
     * @return \Illuminate\Http\Response
     */
    public function index(Resource $resource)
    {
        return view('resource.connections.index', compact('resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Resource $resource)
    {
        $connectingResource = ResourceType::find($request->query('connectingResource'));

        return view('resource.connections.create', compact('resource', 'connectingResource'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource             $resource
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resource $resource)
    {
        $existingConnectedResources = $resource->resources
            ->where('resource_type_id', '!=', $resource->definition->id)
            ->pluck('id');

        $filteredIds = collect($request->input('resources'))->filter(function ($resourceId) use ($existingConnectedResources) {
            return ! $existingConnectedResources->contains($resourceId);
        });

        $filteredIds->each(function ($connectedResourceId) use ($resource) {
            $connection = $resource->connections()->create([]);

            $connection->resources()->attach($connectedResourceId);
        });

        return redirect()
            ->route('resources.edit', $resource)
            ->with('status', "You've just enabled some crazy inter-linking between data. Let's hope the universe doesn't explode!");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @param  \App\Connection $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource, Connection $connection)
    {
        $connectedResource = $connection->resource;

        $connection->delete();

        return back()->with('status', "$resource->name and $connectedResource->name were disconnected from each other. Nothing lasts forever...");
    }
}
