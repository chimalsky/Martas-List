<?php

namespace App\Http\Controllers;

use Str;
use App\Resource;
use App\Temporality;
use Illuminate\Http\Request;

class ResourceTemporalitiesController extends Controller
{
    public function index(Resource $resource, Request $request) 
    {
        return view('resource.temporalities.index', compact('resource'));
    }

    public function store(Resource $resource, Request $request)
    {
        $params = $request->validate([
            'name' => 'string | max:255',
            'date-range' => 'required',
            'start_precision' => 'nullable',
            'end_precision' => 'nullable'
        ]);

        $startDate = trim(Str::before($params['date-range'], 'to'));
        $endDate = trim(Str::after($params['date-range'], 'to'));
        
        $resource->temporalities()->create([
            'name' => $params['name'],
            'start' => $startDate,
            'end' => $endDate,
            'start_precision' => $params['start_precision'],
            'end_precision' => $params['end_precision']
        ]);

        return back()->with('status', "Temporality added!");
    }

    public function update(Resource $resource, Request $request)
    {
        
    }

    public function destroy(Resource $resource, Temporality $temporality, Request $request)
    {
        $temporality->delete();
        return back()->with('status', 'Temporality was deleted');
    }
}
