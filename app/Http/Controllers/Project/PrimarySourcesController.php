<?php

namespace App\Http\Controllers\Project;

use App\ResourceMeta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrimarySourcesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $content = optional(ResourceMeta::find(42071))->value ?? 'No Content Yet';
        $footnotes = optional(ResourceMeta::find(45231))->value ?? 'No Content Yet';

        return view('project.primary-sources', compact('content', 'footnotes'));
    }
}
