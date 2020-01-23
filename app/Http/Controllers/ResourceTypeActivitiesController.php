<?php

namespace App\Http\Controllers;

use App\ResourceType;
use App\ResourceAttribute;
use Illuminate\Http\Request;

class ResourceTypeActivitiesController extends Controller
{
    public function index(Request $request, ResourceType $resourceType)
    {
        $type = $request->query('type') ?? 'resource_meta';
        $filter = $request->query('filter') ?? null;

        if ($type == 'resource_meta') {
            $activities = $resourceType->metaActivities()
                ->paginate(25);
        } else {
            $activities = $resourceType->mediaActivities()
                ->paginate(10);
        }

        return view('resource-type.activities.index', compact('resourceType', 'activities', 'type'));
    }
}
