<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\ResourceType;
use App\ResourceAttribute;
use App\Http\Controllers\Controller;
use App\Project\Poem;
use App\Project\Transcription;
use Illuminate\Http\Request;

class PoemsController extends Controller
{ 
    public function index(Request $request)
    {
        $poems = Poem::with('facsimiles')->orderBy('name');

        if ($query = $request->query('query')) {
            $poems = $poems->byTranscriptionText($query);
        }
        
        $filterables = collect($request->query('filterable'));

        if ($filterables->count()) {
            foreach ($filterables as $filterableId => $filterableValues) {
                $poems = $poems->whereHas('meta', function ($query) use ($filterableId, $filterableValues) {
                    $query = $query->where('resource_attribute_id', $filterableId)
                        ->whereIn('value', $filterableValues);
                });
            }
        }

        $poems = $poems->get();

        $filterables = ResourceAttribute::whereIn('id', $filterables->keys()->toArray())->get();

        if ($request->wantsJson()) {
            return view('project.poems.results', compact('poems', 'filterables'));
        }

        return view('project.poems.index', compact('poems', 'filterables'));
    }

    public function show(Request $request, $poemId)
    {
        $poem = Poem::with(['meta', 'connections'])
            ->find($poemId);

        $birdCategories = $poem->categories()->where('resource_type_id', 19)->get();
        $birds = $birdCategories->pluck('resources')->flatten();
        //$birds = $poem->resources->where('resource_type_id', 2);
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
