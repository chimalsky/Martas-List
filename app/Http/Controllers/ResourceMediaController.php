<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceMedia as Media;
use Illuminate\Http\Request;

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
            'name' => 'nullable|string|max:255',
            'media' => 'required|file',
            'collection' => 'nullable',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'sound_type' => 'nullable|string|max:255',
            'background_sounds' => 'nullable|string|max:255',
            'citation' => 'nullable',
        ]);

        $media = $resource->addMediaFromRequest('media')
            ->usingName($request->name ?? 'unnamed')
            ->toMediaCollection($request->collection ?? 'default');

        $media->date = $request->date;
        $media->time = $request->time;
        $media->location = $request->location;
        $media->sound_type = $request->sound_type;
        $media->background_sounds = $request->background_sounds;
        $media->citation = $request->citation;

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
            'name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'sound_type' => 'nullable|string|max:255',
            'background_sounds' => 'nullable|string|max:255',
            'citation' => 'nullable',
        ]);

        /*$media->name = $request->name;
        $media->date = $request->date;
        $media->time = $request->time;
        $media->location = $request->location;
        $media->sound_type = $request->sound_type;
        $media->background_sounds = $request->background_sounds;
        $media->citation = $request->citation; */

        $media->update([
            'name' => $request->name,
        ]);

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
