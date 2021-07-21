<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\ResourceType;
use App\ResourceAttribute;
use App\Http\Controllers\Controller;
use App\Project\Bird;
use App\Project\ChronoBird;
use App\Project\MonthEnum;
use App\Project\SeasonMonthsEnum;
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
            }])
            ->orderBy('name', $request->query('sort_direction') ?? 'asc');

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

        $chronoDict = [
            '19' => ChronoBird::nineteenthCenturyResourceType(),
            '20' => ChronoBird::twentiethCenturyResourceType(),
            '21' => ChronoBird::twentyFirstCenturyResourceType()
        ];

        $century = $request->query('century');

        if ($century) {
            $chronoResourceType = $chronoDict[$century];

            $fooBirds = $birds;

            $presenceConnections = $fooBirds->with('chronoConnections')->get()
                ->pluck('chronoConnections')
                ->flatten()
                ->filter(function($connection) use ($chronoResourceType) { 
                    $bird = $connection->otherBird;

                    if (is_null($bird)) {
                        return;
                    }
                    
                    if ($bird->resource_type_id !== $chronoResourceType) {
                        return;
                    }

                    
                    return $bird->presenceMeta; 
                });

            if ($seasons = $request->query('seasons')) {
                $filteredBirdsByPresence = $presenceConnections
                    ->filter(function($connection) use ($seasons) {
                        $bird = $connection->otherBird;

                        $presence = $bird->presenceMeta->value;

                        $months = collect(array_map('trim', explode(',', $presence)));

                        foreach ($seasons as $season) {
                            foreach (SeasonMonthsEnum::getConstant($season) as $month) {
                                if ($months->contains($month)) {
                                    return true;
                                }
                            }
                        }
                    });
            }

            if ($months = $request->query('months')) {
                $filteredBirdsByPresence = $presenceConnections
                    ->filter(function($connection) use ($months) {
                        $bird = $connection->otherBird;

                        $stints = collect(explode(';', $bird->presenceMeta->value));

                        $segments = $stints->map(function($stint) {
                            return collect(explode(',', $stint))
                                ->map(function($month) { 
                                    return (int) $month; 
                                });
                            })->flatten();

                        foreach ($months as $month) {
                            $month = MonthEnum::getConstant($month);

                            if ($segments->contains($month)) {
                                return true;
                            }
                        }
                    });
            }

            $birds = $birds->whereIn('id', isset($filteredBirdsByPresence)
                ? $filteredBirdsByPresence->pluck('primary_bird_id')
                : $presenceConnections->pluck('primary_bird_id'));
        } else {
            $months = [];
            $seasons = [];
        }


        $results = $birds->paginate(6);

        return view('project.birds.results', compact('results', 'activeFilterables', 'activeBirds', 'months', 'seasons', 'century', 'query'));
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
