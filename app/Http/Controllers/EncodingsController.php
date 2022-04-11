<?php

namespace App\Http\Controllers;

use App\Encoding;
use Illuminate\Http\Request;

class EncodingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encodings = Encoding::with('resources')->get();

        return view('encodings.index', compact('encodings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('encodings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'encoder_assigned_id' => 'required',
        ]);

        $encoding = Encoding::create($request->all());

        return redirect()->route('encodings.edit', $encoding)
            ->with('status', "$encoding->encoder_assigned_id was created. Now you can add tags to it.");
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
        return view('encodings.edit', compact('encoding'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encoding  $encoding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encoding $encoding)
    {
        $request->validate([
            'encoder_assigned_id' => 'required',
        ]);

        $encoding = $encoding->update($request->all());

        return back()->with('status', 'Encoding was updated! Good job, Marta!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encoding  $encoding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encoding $encoding)
    {
        $encodingName = $encoding->name;
        $encoding->delete();

        return redirect()->route('encodings.index')
            ->with('status', "Rest in Peace $encodingName");
    }
}
