<?php

namespace App\Http\Controllers;

use App\ResourceAttribute;
use App\ResourceMeta;
use App\ResourceType;
use DB;
use Illuminate\Http\Request;
use Str;

class ResourceTypeAttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceType $resourceType)
    {
        $resourceType->load('attributes');
        $resourceType->attributes->loadCount('meta');

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
            'title' => 'required | string | max:255',
            'subtitle' => 'nullable | string | max:255',
            'type' => 'required',
        ]);

        $resourceType->allAttributes()->create([
            'key' => $request->title,
            'subtitle' => $request->subtitle,
            'type' => $request->type,
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
        $attributeValues = ResourceMeta::select('id', 'value')
            ->where('resource_attribute_id', $attribute->id);

        $uniqueValues = $attributeValues->get()->unique('value');

        $aggregate = DB::table('resource_metas')
            ->where('resource_attribute_id', $attribute->id)
            ->selectRaw('count(*) as total');

        foreach ($uniqueValues as $value) {
            $id = $value->id;
            $value = addslashes($value->value);

            $aggregate = $aggregate
             ->selectRaw("count(case when value = '{$value}' then 1 end) as c_{$id}");
        }

        $aggregate = $aggregate->first();

        $uniqueValues = $uniqueValues->map(function ($value) use ($aggregate) {
            $property = 'c_'.$value->id;
            $value->resources_count = $aggregate->$property;

            return $value;
        });

        /*$m = collect($attribute->options)->filter(function($obj) {
            return !is_array($obj);
        });
        $attribute->update([
            'options' => $m->toArray()
        ]);
*/
        //dd($attribute->options);
        return view('resource-type.attributes.edit', compact('resourceType', 'attribute', 'uniqueValues', 'aggregate'));
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
            'title' => 'required | string | max:255',
            'subtitle' => 'nullable | string | max:255',
            'type' => 'required',
            'visibility' => 'nullable',
            'options' => 'nullable | array',
            'optionBlocks' => 'nullable | array',
        ]);

        $params = [
            'key' => $request->title,
            'subtitle' => $request->subtitle,
            'type' => $request->type,
        ];

        if ($request->has('visibility')) {
            $params['visibility'] = $request->visibility;
        }

        $resourceAttribute->update($params);

        if ($request->options) {
            $optionsCollection = collect($request->options)->unique();

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

        return back()->with('status', 'Okay new order is here to stay!');
    }
}
