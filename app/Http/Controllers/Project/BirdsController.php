<?php

namespace App\Http\Controllers\Project;

use App\Resource;
use App\ResourceType;
use App\ResourceAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BirdsController extends Controller
{
    public function index(Request $request)
    {
        return view('project.birds.index');
    }

    public function show(Request $request, $birdId)
    {
        $bird = Resource::with(['meta', 'connections'])
            ->find($birdId);

        $birdCategory = $bird->category;

        if ($birdCategory) {
            $connectedPoemsIds = $birdCategory->connections->pluck('id');
            $poems = Resource::with('media')->whereIn('id', $connectedPoemsIds)->get();
        } else {
            $poems = collect([]);
        }

        return view('project.birds.show', compact('bird', 'birdCategory', 'poems'));
    }
}
