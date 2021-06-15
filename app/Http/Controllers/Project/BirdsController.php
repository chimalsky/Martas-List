<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\ResourceType;
use App\ResourceAttribute;
use App\Http\Controllers\Controller;
use App\Project\Bird;
use App\ResourceCategory;
use Illuminate\Http\Request;

class BirdsController extends Controller
{
    public function index(Request $request)
    {
        $filterables = collect($request->query('filterable'));

        $activeFilterables = ResourceAttribute::ordered()->whereIn('id', $filterables->keys()->toArray())->get();

        return view('project.birds.index');
    }

    public function indexFetch(Request $request)
    {
        $filterables = collect($request->query('filterable'));

        $activeFilterables = ResourceAttribute::ordered()
            ->whereIn('id', $filterables->keys()->toArray())->get();

        $birds = Bird::select('id', 'name')
            ->with(['xc_citation', 'meta' => function ($query) use ($activeFilterables) {
                $query->whereIn('resource_attribute_id', $activeFilterables->pluck('id'));
            }]);

        if ($query = $request->query('query')) {
            $birds = $birds->where('name', 'like', "%$query%");
        }

        $filterableBirds = collect($request->query('filterableBird'));
        
        if ($filterableBirds->count()) {
            $activeBirds = ResourceCategory::with('connections')
                ->where('resource_type_id', Bird::$resource_type_id)
                ->whereIn('id', $request->query('filterableBird'))
                ->get();

            $birds = $birds->whereIn('resource_category_id', $activeBirds->pluck('id'));
        } else {
            $activeBirds = [];
        }

        if ($activeFilterables->count()) {
            foreach ($activeFilterables as $filterable) {
                $activeFilterableValues = $filterables[$filterable->id];

                $birds = $birds->withFilterableValues($filterable, $activeFilterableValues);
            }
        }

        $results = $birds->paginate(6);

        return view('project.birds.results', compact('results', 'activeFilterables', 'activeBirds'));
    }

    public function show(Request $request, Bird $bird)
    {
        $bird->load(['meta', 'connections', 'xc_citation']);

        $birdCategory = $bird->category;

        if ($birdCategory) {
            $connectedPoemsIds = $birdCategory->connections->pluck('id');
            $poems = Resource::with('media')->whereIn('id', $connectedPoemsIds)->get();
        } else {
            $poems = collect([]);
        }

        return view('project.birds.show', compact('bird', 'birdCategory', 'poems'));
    }
}
