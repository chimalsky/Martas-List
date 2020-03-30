<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BirdsController extends Controller
{
    public function index(Request $request)
    {
        $birds = Resource::with(['meta', 'connections'])
            ->where('resource_type_id', 2)
            ->orderBy('name')
            ->get();

        return view('project.birds.index', compact('birds'));
    }

    public function show(Request $request, $birdId)
    {
        $bird = Resource::with(['meta', 'connections'])
            ->find($birdId);

        $poems = $bird->resources->where('resource_type_id', 3);

        return view('project.birds.show', compact('bird', 'poems'));
    }
}
