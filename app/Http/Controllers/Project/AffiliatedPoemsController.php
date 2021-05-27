<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\Http\Controllers\Controller;
use App\Project\Poem;
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

        $poems = Poem::where('resource_category_id', $category->id)
            ->where('id', '!=', $poem->id)
            ->with('facsimiles')
            ->get();
        
        $firstline = $poems->first()->firstMetaByAttribute(84)->value ?? $poems->first()->name;

        $additionalAffiliations = $poem->metaByAttribute(611);

        return view('project.poems.affiliated', compact('category', 'poems', 'poem', 'firstline', 'additionalAffiliations'));
    }
}
