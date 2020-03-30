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
    public function index(ResourceType $resourceType)
    {
        return view('resource-type.attributes.index', compact('resourceType'));
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
            'type' => 'required',
        ]);

        $resourceType->allAttributes()->create([
            'key' => $request->input('name'), 
            'type' => $request->input('type')
        ]);
        
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
    public function edit(ResourceType $resourceType, ResourceAttribute $resourceAttribute)
    {
        $attribute = $resourceAttribute;
        return view('resource-type.attributes.edit', compact('resourceType', 'attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceAttribute  $resourceAttribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResourceType $resourceType, ResourceAttribute $resourceAttribute)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'options' => 'nullable | array'
        ]);

        $resourceAttribute->update([
            'key' => $request->name,
            'type' => $request->type
        ]);

        if ($request->options) {
            $optionsCollection = collect($request->options)->filter(function($option) {
                return $option;
            });

            $resourceAttribute->options = $optionsCollection->toArray();
            $resourceAttribute->save();
        }

        return back()->with('status', "$resourceAttribute->name was updated. Now you are more effecient. Good job, human! Now go become even more effecient!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceAttribute  $resourceAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceType $resourceType, ResourceAttribute $resourceAttribute)
    {
        $resourceAttribute->delete();

        return redirect()
            ->route('resource-types.edit', $resourceType)
            ->with('status', "$resourceAttribute->name attribute removed. Now you are more effecient. Good job, human! Now go become even more effecient!");
    }

    public function sortIndex(Request $request, ResourceType $resourceType)
    {
        return view('resource-type.attributes.index', compact('resourceType'));
    }

    public function sort(Request $request, ResourceType $resourceType)
    {
        ResourceAttribute::setNewOrder($request->input('attributes'));

        return back()->with('status', "Okay new order is here to stay!");
    }
}
