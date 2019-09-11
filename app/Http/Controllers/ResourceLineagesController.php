<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;

class ResourceLineagesController extends Controller
{
    public function index(Resource $resource)
    {
        return view('resource.lineages.index', compact('resource'));
    }

    public function store(Resource $resource, Request $request)
    {
        if ($parent = $request->input('parent')) {
            $resource->parent()->associate($request->input('parent'));
        }

        if ($request->query('children')) {
            $resource->children()->each(function($child) use ($resource) {
                $child->parent_id = null;
                $child->save();
            });

            if ($children = $request->input('child')) {
                $children = Resource::whereIn('id', $children);

                $children->each(function($child) use ($resource) {
                    $child->parent()->associate($resource);
                    $child->save();
                });
            }
        }

        $resource->save();

        return back()->with('status', 'Parent and Child are good to go now');
    }
}
