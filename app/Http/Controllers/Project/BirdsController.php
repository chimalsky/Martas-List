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
}
