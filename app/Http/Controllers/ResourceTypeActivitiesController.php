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

        if ($filter) {
            $activities = $activities->filter(function($activity) use ($filter) {
                return $filter == $activity->subject->resource_attribute_id;
            });
        }

        return view('resource-type.activities.index', compact('resourceType', 'activities', 'type'));
    }
}
