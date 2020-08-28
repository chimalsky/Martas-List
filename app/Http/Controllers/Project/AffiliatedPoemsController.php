<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AffiliatedPoemsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $poemId)
    {
        $poem = Resource::with(['meta', 'connections', 'category'])
            ->find($poemId);

        $category = $poem->category;
        $poems = $category->resources;
        $firstline = $poems->first()->firstMetaByAttribute(84)->value ?? $poems->first()->name;

        return view('project.poems.affiliated', compact('category', 'poems', 'firstline'));
    }
}
