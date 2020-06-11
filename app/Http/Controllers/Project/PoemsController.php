<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\ResourceType;
use App\ResourceAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PoemsController extends Controller
{ 
    public function index(Request $request)
    {
        $poemId = 3;

        $filteredAttributeOptions = collect($request->input('attributeOptions'));
        $filteredAttributes = ResourceAttribute::whereIn('id', $filteredAttributeOptions->keys())->get();

        $sortedAttribute = $request->input('order');

        $filteredBirds = collect($request->input('birds'));
        
        $poems = Resource::with(['media', 'meta' => function($query) use ($filteredAttributes) {
            // 84 == first line 
            // 149 == needs placeholder image for facs?
            $attributeIds = [84, 149];

            foreach ($filteredAttributes as $a) {
                $attributeIds[] = $a->id;
            }
            
            $query->whereIn('resource_attribute_id', $attributeIds);
        }])
            ->where('resource_type_id', $poemId);

        $poemDefinition = ResourceType::find($poemId);
        $queries = collect();
        
        $queryAttribute = ResourceAttribute::find($request->input('query_key'));

        $queryValue = $request->input('query_value');
        $queries = collect();
        
        if ($queryAttribute && $queryValue) {
            $queries->push(
                (object) [
                    'query' => $queryValue,
                    'attribute' => $queryAttribute
                ]
            );
        } else {
            $queryAttribute = ResourceAttribute::find(131);
        }

        if ($filteredAttributes->count()) {
            foreach ($filteredAttributes as $attribute) {
                $poems = $poems->whereHas('meta', function ($query) use ($attribute, $filteredAttributeOptions) {
                    $query = $query->where('resource_attribute_id', $attribute->id);

                    if ($filteredAttributeOptions->keys()->contains($attribute->id)) {
                        $query = $query->whereIn('value', array_keys($filteredAttributeOptions[$attribute->id]));
                    }

                    return $query;
                });
            }
        }

        if ($sortedAttribute) {
            $poems = $poems->addSelect(['queries_meta_value' => function($query) use ($sortedAttribute) {
                $query->select('value')
                    ->from('resource_metas')
                    ->whereColumn('resource_id', 'resources.id')
                    ->where('resource_attribute_id', $sortedAttribute)
                    ->latest()->limit(1);
            }])
            ->orderBy('queries_meta_value', 'asc');
        }

        $poems = $poems->get();

        $poems = $poems->groupBy('queries_meta_value');

        $birds = Resource::where('resource_type_id', 2)
            ->orderBy('name')->get();

        if ($request->method() == 'GET') {
            return view('project.poems.index', 
                compact('poemDefinition', 'filteredAttributes', 'filteredAttributeOptions', 'poems', 'birds', 'sortedAttribute', 'queries')
            );
        } else {
            return view('project.poems._index', compact('poems'));
        }
    }

    public function indexAsync(Request $request)
    {

    }

    public function show(Request $request, $poemId)
    {
        $poem = Resource::with(['meta', 'connections'])
            ->find($poemId);

        $birds = $poem->resources->where('resource_type_id', 2);
        $variants = $poem->resources->where('resource_type_id', 3);

        return view('project.poems.show', compact('poem', 'birds', 'variants'));
    }
}
