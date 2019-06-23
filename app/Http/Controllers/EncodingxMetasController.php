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
        $encoding->createMeta($request->input('name'), $request->input('value'));

        dd($encoding);

        return back()->with('status', "Encoding Tag ($request->input('name')) was added! Good job, Marta!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EncodingsMeta  $encodingsMeta
     * @return \Illuminate\Http\Response
     */
    public function show(EncodingsMeta $encodingsMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EncodingsMeta  $encodingsMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(EncodingsMeta $encodingsMeta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EncodingsMeta  $encodingsMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EncodingsMeta $encodingsMeta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EncodingsMeta  $encodingsMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(EncodingsMeta $encodingsMeta)
    {
        //
    }
}
