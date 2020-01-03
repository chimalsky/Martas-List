<?php

namespace App\Http\Controllers;

use App\ResourceType;
use Illuminate\Http\Request;

class ResourceTypeActivitiesController extends Controller
{
    public function index(Request $request, ResourceType $resourceType)
    {
        $type = $request->query('type') ?? 'resource_meta';

        if ($type == 'resource_meta') {
            $activities = $resourceType->metaActivities()->inLog($type)->get();
        } else {
            $activities = $resourceType->mediaActivities()->inLog($type)->get();
        }

        return view('resource-type.activities.index', compact('resourceType', 'activities', 'type'));
    }
}
