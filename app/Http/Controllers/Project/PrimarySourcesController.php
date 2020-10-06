<?php

namespace App\Http\Controllers\Project;

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
        dd('primary-sources');
        $content = file_get_contents(base_path('/project/content/primary-sources.md'));

        return view('project.primary-sources', compact('content'));
    }
}
