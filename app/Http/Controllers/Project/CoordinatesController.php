<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\ResourceMeta;
use Illuminate\Http\Request;

class CoordinatesController extends Controller
{
    public function __invoke(Request $request)
    {
        $content = optional(ResourceMeta::find(42070))->value ?? 'No Content Yet';

        return view('project.coordinates', compact('content'));
    }
}
