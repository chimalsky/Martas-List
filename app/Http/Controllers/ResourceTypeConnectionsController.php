<?php

namespace App\Http\Controllers;

use App\ResourceType;
use Illuminate\Http\Request;

class ResourceTypeConnectionsController extends Controller
{
    public function update(Request $request, ResourceType $resourceType)
    {
        $connections = $request->input('resourceTypeConnections') ?? [];
        $connectionsParams = ResourceType::whereIn('id', $connections)->get()
            ->map(function($rt) {
                return [
                    'key' => $rt->id,
                    'type' => 'connection'
                ];
            })->toArray();  

        $resourceType->connections()->delete();

        $resourceType->connections()->createMany($connectionsParams);

        return back()->with('status', 'Okay that was good!');
    }
}
