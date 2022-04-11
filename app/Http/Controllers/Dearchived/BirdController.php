<?php

namespace App\Http\Controllers\Dearchived;

use App\Resource;
use App\ResourceType;
use Illuminate\Http\Request;
use Str;

class BirdController
{
    public function show(Request $request)
    {
        $month = $request->query('month') ?? 'january';
        $year = $request->query('year') ?? 1863;

        $months = collect([
            'january', 'february', 'march',
            'april', 'may', 'june',
            'july', 'august', 'september',
            'october', 'november', 'december',
        ]);

        $birdResource = ResourceType::where('name', 'like', 'Bird Archive')->first();

        $birds = Resource::with('connections.resources')
            ->type($birdResource->id)
            ->withSeason()
            ->get();

        $birds = $birds->filter(function ($bird) use ($month) {
            if (! $bird->season) {
                return;
            }

            $value = strtolower($bird->season->value);

            return Str::contains($value, $month) ||
                $value == 'resident';
        });

        return view('dearchived.bird.index', compact('birds', 'year', 'month', 'months'));
    }
}
