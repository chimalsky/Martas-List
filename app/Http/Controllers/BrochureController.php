<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrochureController extends Controller
{
    public function index() 
    {
        return view('brochure.index');
    }

    public function show()
    {
        return view('brochure.show');
    }
}
