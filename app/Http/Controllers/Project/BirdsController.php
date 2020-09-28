<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\ResourceType;
use App\ResourceAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BirdsController extends Controller
{
    public function index(Request $request)
    {
        $birdId = 2;

        $birdDefinition = ResourceType::find($birdId);

        $birds = Resource::with(['meta', 'connections'])
            ->where('resource_type_id', $birdId)
            ->orderBy('name');

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
            $queryAttribute = $birdDefinition   ->attributes->first();
        }

        if ($queryValue) {
            $birds = $birds->whereHas('meta', function ($query) use ($queryAttribute, $queryValue) {
                $query = $query->where('resource_attribute_id', $queryAttribute->id)
                    ->where('value', 'LIKE', "%{$queryValue}%");
    
                return $query;
            });
        }

        $birds = $birds->get();

        return view('project.birds.index', compact('birdDefinition', 'birds', 'queries'));
    }

    public function show(Request $request, $birdId)
    {
        $bird = Resource::with(['meta', 'connections'])
            ->find($birdId);

        $birdCategory = $bird->category;

        if ($birdCategory) {
            $connectedPoemsIds = $birdCategory->connections->pluck('id');
            $poems = Resource::with('media')->whereIn('id', $connectedPoemsIds)->get();
        } else {
            $poems = collect([]);
        }

        return view('project.birds.show', compact('bird', 'poems'));
    }
}
