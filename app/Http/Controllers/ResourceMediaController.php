<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class ResourceMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function index(Resource $resource)
    {
        return view('resource.media.index', compact('resource'));
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
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resource $resource)
    {        
        $request->validate([
            'media' => 'required|file',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'background_sounds' => 'nullable|string|max:255'
        ]);
        
        $media = $resource->addMediaFromRequest('media')
            ->usingName($request->input('name') ?? 'unnamed')
            ->toMediaCollection();
        
        $media->date = $request->date;
        $media->time = $request->time;
        $media->location = $request->location;
        $media->background_sounds = $request->background_sounds;
        $media->save();

        return back()->with('status', "Media was attached to $resource->name.");
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
     * @param  \Spatie\MediaLibrary\Models\Media @medium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource, Media $media)
    {
        $request->validate([
            'date' => 'nullable|date',
            'time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'background_sounds' => 'nullable|string|max:255'
        ]);

        $media->name = $request->name;
        $media->date = $request->date;
        $media->time = $request->time;
        $media->location = $request->location;
        $media->background_sounds = $request->background_sounds;
        $media->save();

        return back()->with('status', "Media $media->name was updated, bro!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @param  \Spatie\MediaLibrary\Models\Media @medium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource, Media $media)
    {
        $media->delete();
        return back()->with('status', "Media ($media->name) was deleted! RIP the old, Welcome the new!"); 
    }
}
