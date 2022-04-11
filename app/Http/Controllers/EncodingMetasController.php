<?php

namespace App\Http\Controllers;

use App\Encoding;
use App\EncodingMeta;
use Illuminate\Http\Request;

class EncodingMetasController extends Controller
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
     * @param \App\Encoding $encoding
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Encoding $encoding, Request $request)
    {
        $meta = new EncodingMeta($request->all());
        $encoding->meta()->save($meta);

        $metaKey = $request->input('key');

        return back()->with('status', "Encoding Tag ($metaKey) was added! Good job, Marta!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encoding  $encoding
     * @return \Illuminate\Http\Response
     */
    public function show(Encoding $encoding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encoding  $encoding
     * @return \Illuminate\Http\Response
     */
    public function edit(Encoding $encoding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encoding  $encoding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encoding $encoding, EncodingMeta $meta)
    {
        $meta->update($request->all());

        return back()->with('status', "Encoding Tag ($meta->key) was updated! The world is now a cleaner place");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encoding  $encoding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encoding $encoding, EncodingMeta $meta)
    {
        $meta->delete();

        return back()->with('status', "Encoding Tag ($meta->key) was deleted! RIP the old, Welcome the new!");
    }
}
