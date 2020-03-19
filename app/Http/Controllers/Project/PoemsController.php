<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PoemsController extends Controller
{ 
    public function index(Request $request)
    {
        $poems = Resource::with(['meta', 'media'])
            ->where('resource_type_id', 3);


        $poems = $poems->addSelect(['queries_meta_value' => function($query)  {
            $query->select('value')
                ->from('resource_metas')
                ->whereColumn('resource_id', 'resources.id')
                ->where('resource_attribute_id', 131)
                ->latest()->limit(1);
        }])
        ->orderBy('queries_meta_value', 'asc')
        ->get();

        return view('project.poems.index', compact('poems'));
    }

    public function show(Request $request, $poemId)
    {
        $poem = Resource::with(['meta', 'connections'])
            ->find($poemId);

        return view('project.poems.show', compact('poem'));
    }
}
