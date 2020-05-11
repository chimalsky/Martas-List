<?php

namespace App\Http\Controllers;

use App\ResourceAttribute;
use Illuminate\Http\Request;

class ResourceAttributeOrganizeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ResourceAttribute $attribute)
    {
        return view('attribute.options.organize', compact('attribute'));
    }
}
