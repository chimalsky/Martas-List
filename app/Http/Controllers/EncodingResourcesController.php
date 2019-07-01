<?php

namespace App\Http\Controllers;

use App\Encoding;
use App\Resource;
use Illuminate\Http\Request;

class EncodingResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Encoding $encoding)
    {
        $encoding->resources()->syncWithoutDetaching($request->input('resources'));

        return back()->with('status', "You've just enabled some crazy inter-linking between data. Let's hope the universe doesn't explode!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EncodingResource  $encodingResource
     * @return \Illuminate\Http\Response
     */
    public function show(EncodingResource $encodingResource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EncodingResource  $encodingResource
     * @return \Illuminate\Http\Response
     */
    public function edit(EncodingResource $encodingResource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EncodingResource  $encodingResource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EncodingResource $encodingResource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EncodingResource  $encodingResource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Encoding $encoding, Resource $resource)
    {
        $encoding->resources()->detach($resource);

        return back()->with('status', "$resource->name was detached from $encoding->encoder_assigned_id");
    }
}
