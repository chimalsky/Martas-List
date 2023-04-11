<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project\Bird;
use App\Project\Poem;
use App\Resource;
use App\ResourceCategory;
use App\ResourceType;
use App\ResourceAttribute;
use Illuminate\Http\Request;

class PoemsController extends Controller
{
    public function index(Request $request)
    {
        $filterables = collect($request->query('filterable'));

        $activeFilterables = ResourceAttribute::ordered()->whereIn('id', $filterables->keys()->toArray())->get();
        $displayableFilterables = $activeFilterables->reject(function ($filterable) {
            return $filterable->id == 84;
        });

        $birds = ResourceCategory::with('connections')
                ->where('resource_type_id', Bird::$resource_type_id)->get();

        $filterableBirds = collect($request->query('filterableBird'));

        $activeBirds = $birds->whereIn('id', $filterableBirds->keys());

        $filterables = ResourceType::find(Poem::$resource_type_id)->attributes->where('visibility', 1);

        return view('project.poems.index', compact('activeFilterables', 'filterables', 'birds', 'activeBirds'));
    }

    public function indexFetch(Request $request)
    {
        $filterables = collect($request->query('filterable'));

        $activeFilterables = ResourceAttribute::ordered()->whereIn('id', $filterables->keys()->toArray())->get();
        $displayableFilterables = $activeFilterables->reject(function ($filterable) {
            // Ignore the first-line attribute
            return $filterable->id == 84;
        });

        $poems = Poem::hasBirds()
            ->whereHas('firstLine')
            ->with(['facsimiles', 'firstLine', 'placeholder', 'year', 'birdCategories.resources',
                'meta' => function ($query) use ($displayableFilterables) {
                    $query->whereIn('resource_attribute_id', $displayableFilterables->pluck('id'));
                }, ]);

        if ($query = $request->query('query')) {
            $franklinQueryResult = Poem::whereHas('franklinId', function ($q) use ($query) {
                $q->where('value', $query);
            });
            
            if ($franklinQueryResult->count()) {
                $poems = $poems->whereIn('id', $franklinQueryResult->pluck('id'));
            } else {
                $poems = $poems->byTranscriptionText($query);
            }
        }

        $birds = ResourceCategory::with('connections')
                ->where('resource_type_id', Bird::$resource_type_id)->get();

        $filterableBirds = collect($request->query('filterableBird'));
        $filteringByUnnamedBirds = $filterableBirds->flatten()->contains('unnamed');
        
        if ($filteringByUnnamedBirds) {
            $filterableBirds = $filterableBirds->reject(function($item, $key) {
                return $key == 'unnamed';
            });
        }

        $activeBirds = $birds->whereIn('id', $filterableBirds->keys());

        if ($filterableBirds->count()) {
            if ($filteringByUnnamedBirds) {
                $unnamedBirdPoemsQuery = clone $poems;
                $unnamedBirdPoems = $unnamedBirdPoemsQuery->mentionsUnnamedBirds()->get();
            }
            $connectedPoemsIds = $activeBirds->pluck('connections')->flatten()->pluck('id');
            $poems = $poems->whereIn('id', $connectedPoemsIds);
        }

        if ($activeFilterables->count()) {
            foreach ($activeFilterables as $filterable) {
                // month
                if ($filterable->id == 623 && $filterables->keys()->contains(138)) {
                    continue;
                }

                $activeFilterableValues = $filterables[$filterable->id];

                $poems = $poems->withFilterableValues($filterable, $activeFilterableValues);
            }
        }

        if ($filteringByUnnamedBirds) {
            if ($filterableBirds->count()) {
                $poems = $poems->get();
                $poems = $poems->merge($unnamedBirdPoems);
            } else {
                $poems = $poems->mentionsUnnamedBirds()->get();
            }
            $activeBirds = $activeBirds->push('Unnamed bird(s)');
        } else {
            $poems = $poems->get();
        }

        $sortable = $request->query('sortable') ?? 'firstline';
        $sortDirection = $request->query('sort_direction') ?? 'asc';

        if ($sortable == 'firstline') {
            $poems = $poems->sortByFirstline($sortDirection);
        } else {
            $poems = $poems->sortByYear($sortDirection);
        }

        $results = $poems;

        $resourceType = ResourceType::find(Poem::$resource_type_id);
        $filterables = $resourceType->attributes->where('visibility', 1);
        $attributeOrder = $filterables->pluck('id')->toArray();

        return view('project.poems.results', compact('results', 'query', 'filterables', 'activeFilterables', 'birds', 'activeBirds', 'attributeOrder'));
    }

    public function show(Request $request, $poemId)
    {
        $poem = Poem::with(['meta', 'connections'])
            ->find($poemId);

        $birdCategories = $poem->categories()->where('resource_type_id', 19)->get();
        $birdIds = $birdCategories->pluck('resources')->flatten()->pluck('id');

        $birds = Bird::with('xc_citation')->whereIn('id', $birdIds)->get();

        $variants = $poem->resources->where('resource_type_id', 3);
        $firstline = $poem->meta->firstWhere('resource_attribute_id', 84)->value ?? null;
        $year = $poem->meta->firstWhere('resource_attribute_id', 131)->value ?? null;
        $season = $poem->meta->firstWhere('resource_attribute_id', 138)->value ?? null;

        $state = $poem->meta->firstWhere('resource_attribute_id', 89)->value ?? null;
        $medium = $poem->meta->firstWhere('resource_attribute_id', 142)->value ?? null;
        $paper = $poem->meta->firstWhere('resource_attribute_id', 87)->value ?? null;

        $setting = $poem->meta->firstWhere('resource_attribute_id', 103)->value ?? null;
        $circulation = $poem->meta->firstWhere('resource_attribute_id', 113)->value ?? null;

        $circulationHistory = $poem->circulationHistory;
        
        $recipients = $circulationHistory->map(function($item) {
            $exploded = explode(' ', $item->value);
            $firstName = reset($exploded);
            $lastName = end($exploded);
            // People Resource attribute = 11
            // not that many so we can fetch them all for each request
            if ($lastName == 'Bowles') {
                $person = Resource::where('resource_type_id', 11)
                    ->where('name', 'like', '%'.$firstName.'%')
                    ->where('name', 'like', '%'.$lastName.'%');
            } else {
                $person = Resource::where('resource_type_id', 11)
                    ->where('name', 'like', '%'.$lastName.'%');
            }
            return $person->first();
        })->reject(function($value) {
            return is_null($value);
        });
        
        return view('project.poems.show',
            compact(
                'poem', 'birds', 'variants',
                'firstline', 'year', 'season',
                'state', 'medium', 'paper',
                'setting', 'circulation',
                'recipients'
            )
        );
    }
}
