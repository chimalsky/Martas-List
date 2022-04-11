<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceMeta;
use Illuminate\Http\Request;

class ResourceMetasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function index(Resource $resource)
    {
        $resource->load(['meta']);

        return view('resource.metas.index', compact('resource'));
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
     * @param \App\Resource $resource
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Resource $resource, Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);

        $meta = new ResourceMeta($request->except('attribute'));
        $resource->meta()->save($meta);

        $metaKey = $request->input('key');

        if ($request->query('attribute')) {
            $status = "$metaKey Attribute saved";
        } else {
            $status = "Resource Tag ($metaKey) was added!";
        }

        return back()->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceMeta  $resourceMeta
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceMeta $resourceMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceMeta  $resourceMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceMeta $resourceMeta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceMeta  $meta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource, ResourceMeta $meta)
    {
        $meta->update($request->except('attribute'));

        if ($request->query('attribute')) {
            $status = "$meta->key Attribute saved";
        } else {
            $status = "Resource Tag ($meta->key) was updated! The world is now a better place";
        }

        return back()->with('status', $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Resource
     * @param  \App\ResourceMeta  $resourceMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource, ResourceMeta $meta)
    {
        $meta->delete();

        return back()->with('status', "Attribute information for ($meta->key) was deleted! RIP the old, Welcome the new!");
    }
}
