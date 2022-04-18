<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\ResourceMeta;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $content = optional(ResourceMeta::find(44501))->value ?? 'No Content Yet';

        return view('project.about', compact('content'));
    }

    public function overview()
    {
        return view('project.about-overview');
    }

    public function navigation()
    {
        return view('project.about-navigation');
    }

    public function documentation()
    {
        return view('project.about-documentation');
    }

    public function sources()
    {
        return view('project.about-sources');
    }

    public function visitors()
    {
        return view('project.about-visitors');
    }

    public function colophon()
    {
        return view('project.about-colophon');
    }
}
