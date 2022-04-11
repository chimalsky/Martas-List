<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');

        /*$activities = Activity::inLog($type)->get()->filter(function($a) {
            return $a->subject;
        }); */

        $activities = Activity::inLog($type)->get();

        dd($activities->pluck('subject.resourceAttribute.resourceType'));

        return view('activity.index', compact('activities', 'type'));
    }
}
