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
        return view('project.poems.index');
    }

    public function show(Request $request, $poemId)
    {
        $poem = Resource::with(['meta', 'connections'])
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
