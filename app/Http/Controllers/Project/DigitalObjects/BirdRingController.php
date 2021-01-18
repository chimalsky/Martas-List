<?php

namespace App\Http\Controllers\Project\DigitalObjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BirdRingController extends Controller
{
    public function __invoke(Request $request)
    {
        return view ('project.digital-objects.birdring');
    }
}
