<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PoemCommentaryController extends Controller
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
        $poems = optional($category)->resources;
        $firstline = $poem->firstMetaByAttribute(84)->value ?? $poems->first()->name;

        return view('project.poems.commentary', compact('category', 'poem', 'firstline'));
    }
}
