<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project\Poem;
use App\Resource;
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
        $poem = Poem::with(['meta', 'connections', 'category', 'facsimiles'])
            ->find($poemId);

        $category = $poem->category;

        $poems = Poem::hasBirds()
            ->where('resource_category_id', $category->id)
            ->where('id', '!=', $poem->id)
            ->with('facsimiles')
            ->get();

        $firstline = $poems->first()->firstMetaByAttribute(84)->value ?? $poems->first()->name;

        $additionalAffiliations = Poem::doesntHaveBirds()
            ->where('resource_category_id', $category->id)
            ->where('id', '!=', $poem->id)
            ->with('facsimiles')
            ->get();

        return view('project.poems.affiliated', compact('category', 'poems', 'poem', 'firstline', 'additionalAffiliations'));
    }
}
