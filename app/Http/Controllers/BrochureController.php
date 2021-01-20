<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceType;
use Illuminate\Http\Request;

class BrochureController extends Controller
{
    public function index() 
    {
        return view('project.index');
    }

    public function show()
    {
        $birdResource = ResourceType::where('name', 'Bird Archive')->first();
        $birds = $birdResource->resources;

        dd($birds, $birdResource);
        return view('brochure.show');
    }
}
