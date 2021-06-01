<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\ResourceType;
use App\ResourceAttribute;
use App\Http\Controllers\Controller;
use App\Project\Bird;
use App\Project\Poem;
use App\Project\Transcription;
use App\ResourceCategory;
use Illuminate\Http\Request;

class PoemsController extends Controller
{ 
    public function index(Request $request)
    {
        $filterables = collect($request->query('filterable'));

        $activeFilterables = ResourceAttribute::ordered()->whereIn('id', $filterables->keys()->toArray())->get();
        $displayableFilterables = $activeFilterables->reject(function($filterable) {
            return $filterable->id == 84;
        });

        $poems = Poem::whereHas('firstLine')
            ->with(['facsimiles', 'firstLine', 'placeholder', 'year', 'birdCategories.resources', 
                'meta' => function ($query) use ($displayableFilterables) {
                    $query->whereIn('resource_attribute_id', $displayableFilterables->pluck('id'));
                }]);

        if ($query = $request->query('query')) {
            $poems = $poems->byTranscriptionText($query);
        }

        if ($filterables->count()) {
            foreach ($filterables as $filterableId => $filterableValues) {
                // month
                if ($filterableId == 623 && $filterables->keys()->contains(138)) {
                    continue;
                }

                $poems = $poems->whereHas('meta', function ($query) use ($filterableId, $filterableValues) {
                    $query = $query->where('resource_attribute_id', $filterableId)
                        ->whereIn('value', $filterableValues);
                });
            }
        }

        $filterableBirds = collect($request->query('filterableBird'));

        if ($filterableBirds->count()) {
            $connectedPoemsIds = ResourceCategory::with('connections')
                ->whereIn('id', $filterableBirds)
                ->get()
                ->pluck('connections')->flatten()->pluck('id');

            $poems = $poems->whereIn('id', $connectedPoemsIds);
        }

        $poems = $poems->get();
        $sortable = $request->query('sortable') ?? 'firstline';
        $sortDirection = $request->query('sort_direction') ?? 'asc';

        if ($sortable == 'firstline') {
            $poems = $poems->sortByFirstline($sortDirection);
        } else {
            $poems = $poems->sortByYear($sortDirection);
            //$results = $poems->groupBy('year.value');
        }

        $results = $poems;

        $birds = ResourceType::with('categories')->find(19)->categories;

        $activeBirds = ResourceCategory::whereIn('id', $filterableBirds)->get();

        if ($request->wantsJson()) {
            return view('project.poems.results', compact('results', 'activeFilterables', 'birds', 'activeBirds'));
        }

        return view('project.poems.index', compact('results', 'activeFilterables', 'birds', 'activeBirds'));
    }

    public function show(Request $request, $poemId)
    {
        $poem = Poem::with(['meta', 'connections'])
            ->find($poemId);

        $birdCategories = $poem->categories()->where('resource_type_id', 19)->get();
        $birds = $birdCategories->pluck('resources')->flatten();

        $variants = $poem->resources->where('resource_type_id', 3);
        $firstline = $poem->meta->firstWhere('resource_attribute_id', 84)->value ?? null;
        $year = $poem->meta->firstWhere('resource_attribute_id', 131)->value ?? null;
        $season = $poem->meta->firstWhere('resource_attribute_id', 138)->value ?? null;

        $state = $poem->meta->firstWhere('resource_attribute_id', 89)->value ?? null;
        $medium = $poem->meta->firstWhere('resource_attribute_id', 142)->value ?? null;
        $paper = $poem->meta->firstWhere('resource_attribute_id', 87)->value ?? null;

        $setting = $poem->meta->firstWhere('resource_attribute_id', 103)->value ?? null;
        $circulation = $poem->meta->firstWhere('resource_attribute_id', 113)->value ?? null;

        return view('project.poems.show', 
            compact(
                'poem', 'birds', 'variants', 
                'firstline', 'year', 'season',
                'state', 'medium', 'paper',
                'setting', 'circulation'
            )
        );
    }
}
