<?php

namespace App\Http\Controllers;

use App\Resource;
use App\Connection;
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
    public function create()
    {
        //
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
        collect($request->input('resources'))->each(function($connectedResourceId) use ($resource) {
            $connection = $resource->connections()->create([]);

            $connection->resources()->attach($connectedResourceId);
        });

        return back()->with('status', "You've just enabled some crazy inter-linking between data. Let's hope the universe doesn't explode!");
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
