<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\ResourceMeta;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke(Request $request)
    {
        dd('about');
        $content = optional(ResourceMeta::find(42070))->value ?? 'No Content Yet';

        return view('project.about', compact('content'));
    }
}
