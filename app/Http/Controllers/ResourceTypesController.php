<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceType;
use App\ResourceMeta;
use App\ResourceAttribute;
use Illuminate\Http\Request;

class ResourceTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resourceTypes = ResourceType::all();

        return view('resource-types.index', compact('resourceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resourceType = new ResourceType;

        return view('resource-types.create', compact('resourceType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required | string | max:255',
            'subtitle' => 'nullable | string | max:255',
            'description' => 'nullable',
        ]);

        $validated['project_id'] = 0;

        $resourceType = ResourceType::create($validated);
        
        return redirect()->route('resource-types.show', $resourceType)
            ->with('status', "A new type of resource -- $resourceType->name -- was created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceType $resourceType, Request $request)
    {
        $enabledAttributes = collect($request->query('attribute'))->keys();

        $enabledAttributes = ResourceAttribute::whereIn('id', $enabledAttributes)->get();
        $filteredAttributeOptions = collect($request->query('attributeOption'));
        
        $reverse = $request->query('reverse') ? 'desc' : 'asc';
        $sortMeta = $request->query('sortMeta') ?? $enabledAttributes[0] ?? null;
        $sortName = $request->query('sortName') ?? null;

        $resources = $resourceType->resources();

        if ($enabledAttributes->count()) {
            foreach ($enabledAttributes as $attribute) {
                $resources = $resources->whereHas('meta', function ($query) use ($attribute, $filteredAttributeOptions) {
                    $query = $query->where('resource_attribute_id', $attribute->id);

                    if ($filteredAttributeOptions->keys()->contains($attribute->id)) {
                        $query = $query->whereIn('value', array_keys($filteredAttributeOptions[$attribute->id]));
                    }

                    return $query;
                });
            }
        }

        $resources->with(['media', 'meta' => function($query) use ($enabledAttributes) {
            return $query->whereNotNull('value')
                ->whereIn('resource_attribute_id', $enabledAttributes->pluck('id'));
            }]);
                
        if ($sortMeta) {
            $resources = $resources->addSelect(['queries_meta_value' => function($query) use ($sortMeta) {
                $query->select('value')
                    ->from('resource_metas')
                    ->whereColumn('resource_id', 'resources.id')
                    ->where('resource_attribute_id', $sortMeta)
                    ->latest()->limit(1);
            }])
            ->orderBy('queries_meta_value', $reverse);
        } else {
            $resource = $resources->orderBy('name', $reverse);
        }

        $resources = $resources
            ->paginate(40);

        return view('resource-types.show', compact('resourceType', 
            'enabledAttributes',
            'filteredAttributeOptions',
            'resources'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceType $resourceType)
    {
        return view('resource-types.edit', compact('resourceType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResourceType $resourceType)
    {
        $validated = $request->validate([
            'name' => 'required',
            'subtitle' => 'nullable | string | max:255',
            'description' => 'nullable'
        ]);

        $resourceType->update($validated);
        
        return redirect()->route('resource-types.show', $resourceType)
            ->with('status', "An existing type of resource -- $resourceType->name -- was updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceType $resourceType)
    {
        //
    }
}
