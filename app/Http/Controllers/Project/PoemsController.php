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

        $poems = Resource::with(['meta', 'media'])
            ->where('resource_type_id', $poemId);

        $poemDefinition = ResourceType::find($poemId);
        
        $queryAttribute = ResourceAttribute::find($request->input('query_key'));
        $queryValue = $request->input('query_value');
        $queries = collect();
        
        foreach ($request->input('query'))

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

        if ($queryValue) {
            $poems = $poems->whereHas('meta', function ($query) use ($queryAttribute, $queryValue) {
                $query = $query->where('resource_attribute_id', $queryAttribute->id)
                    ->where('value', 'LIKE', "%{$queryValue}%");
    
                return $query;
            });
        }

        $poems = $poems->get();

        return view('project.poems.index', 
            compact('poemDefinition', 'poems', 'queries')
        );
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
