<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Resource;
use Illuminate\Http\Request;

class BirdsDataController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Resource $bird)
    {
        $birdLists = $bird->resources->pluck('definition');

        return view('project.birds.data', compact('bird', 'birdLists'));
    }
}
