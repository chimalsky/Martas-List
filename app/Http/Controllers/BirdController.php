<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceType;
use Illuminate\Http\Request;

class BirdController extends Controller
{
    public function show()
    {
        $birdResource = ResourceType::where('name', 'Bird Archive')->first();
        $birds = $birdResource->resources;

        return view('dearchived.bird.index', compact('birds'));
    }
}
