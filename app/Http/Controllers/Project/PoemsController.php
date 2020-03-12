<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PoemsController extends Controller
{ 
    public function index(Request $request)
    {
        $poems = Resource::with(['meta', 'connections'])
            ->where('resource_type_id', 3)->get();

        return view('project.poems.index', compact('poems'));
    }

    public function show(Request $request, $poemId)
    {
        $poem = Resource::with(['meta', 'connections'])
            ->find($poemId);

        return view('project.poems.show', compact('poem'));
    }
}
