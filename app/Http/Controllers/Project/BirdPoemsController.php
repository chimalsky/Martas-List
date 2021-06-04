<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\Http\Controllers\Controller;
use App\Project\Poem;
use Illuminate\Http\Request;

class BirdPoemsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $birdId)
    {
        $bird = Resource::with(['meta', 'connections'])
            ->find($birdId);

        $birdCategory = $bird->category;

        if ($birdCategory) {
            $connectedPoemsIds = $birdCategory->connections->pluck('id');
            $poems = Poem::with('media')->whereIn('id', $connectedPoemsIds)->get();
        } else {
            $poems = collect([]);
        }

        return view('project.birds.poems.index', compact('bird', 'poems', 'birdCategory'));
    }
}
