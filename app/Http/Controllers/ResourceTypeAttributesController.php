<?php

namespace App\Http\Controllers;

use Str;
use App\ResourceType;
use App\ResourceAttribute;
use Illuminate\Http\Request;

class ResourceTypeAttributesController extends Controller
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
    public function store(Request $request, ResourceType $resourceType)
    {        
        $request->validate([
            'name' => 'required',
            'type' => 'nullable',
        ]);

        $attributes = $resourceType->extra_attributes->attributes;

        $attribute = new ResourceAttribute([
            'name' => $request->input('name'), 
            'type' => $request->input('type')
        ]);

        $attributes[$request->input('name')] = $attribute->toArray();
                            
        $resourceType->extra_attributes->attributes = $attributes;
        $resourceType->save();

        
        return back()->with('status', "Attributes saved for $resourceType->name resource");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceAttribute  $resourceAttribute
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceAttribute $resourceAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceAttribute  $resourceAttribute
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceAttribute $resourceAttribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceAttribute  $resourceAttribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResourceType $resourceType, String $name)
    {
        $resourceAttribute = new ResourceAttribute(['name' => $request->input('name'), 'type' => $request->input('type')]);
        
        $newName = $request->input('name');

        $resourceType->extra_attributes->set("attributes.$newName", $resourceAttribute);
        $resourceType->save();

        return back()->with('status', "$resourceAttribute->name was updated. Now you are more effecient. Good job, human! Now go become even more effecient!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceAttribute  $resourceAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceType $resourceType, String $name)
    {
        $attributes = $resourceType->mainAttributes; 
        $filtered = collect($attributes)->filter(function($item, $key) use ($name) {
            return $key !== $name;
        });

        $resourceType->extra_attributes->set("attributes", $filtered);

        $resourceType->save();

        return back()->with('status', "$name attribute removed. Now you are more effecient. Good job, human! Now go become even more effecient!");
    }
}
