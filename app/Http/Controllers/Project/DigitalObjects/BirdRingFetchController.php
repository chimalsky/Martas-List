<?php

namespace App\Http\Controllers\Project\DigitalObjects;

use App\Http\Controllers\Controller;
use App\Project\Bird;
use App\Project\ChronoBird;
use App\Project\MonthEnum;
use Illuminate\Http\Request;

class BirdRingFetchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
		$chrono = $request->query('chrono') ?? 'year';
		$months = $this->getMonthsForChrono($chrono);

		$birds = Bird::with(['meta' => function ($query) {
			$query->whereIn('resource_attribute_id', [690, 691, 687, 499])
				->where('value', '<>', '');
		}])->withDynamicValue(688, 'presence')->get();

		$filtered = $birds->filter(function($bird) use ($months) {
			$stints = collect(explode(';', $bird->presence));

			$segments = $stints->map(function($stint) {
				return collect(explode(',', $stint))
					->map(function($month) { 
						return (int) $month; 
					});
				})->flatten();

			foreach ($months as $month) {
				if ($segments->contains($month)) {
					return true;
				}
			}
		});

		$filtered = $filtered->map(function($bird) use ($months) {
			$birdData = [
				'id' => $bird->id,
				'universalSpeciesId' => $bird->meta->firstWhere('resource_attribute_id', 499) ? $bird->meta->firstWhere('resource_attribute_id', 499)->value : null,
				'name' => $bird->name,
				'presence' => $bird->presence,
				'arrival' => $bird->meta->firstWhere('resource_attribute_id', 690) ? $bird->meta->firstWhere('resource_attribute_id', 690)->value : null,
				'departure' => $bird->meta->firstWhere('resource_attribute_id', 691) ? $bird->meta->firstWhere('resource_attribute_id', 691)->value : null,
				'bodymass' => $bird->meta->firstWhere('resource_attribute_id', 687) ? $bird->meta->firstWhere('resource_attribute_id', 687)->value : null,
				'migratoryStatus' => null
			];

			if ($birdData['arrival'] || $birdData['departure']) {
				$arrivalStints = collect(explode(';', $birdData['arrival']))
					->map(function($month) { 
						return (int) $month; 
					});
				$departureStints = collect(explode(';', $birdData['departure']))
					->map(function($month) { 
						return (int) $month; 
					});


				if ($arrivalStints->contains($months[0])) {
					$birdData['migratoryStatus'] = 'arriving';
				} elseif ($departureStints->contains($months[0])) {
					$birdData['migratoryStatus'] = 'departing';
				}
			}

			return $birdData;
		});

        return response()->json($filtered);
    }

	protected function getMonthsForChrono($chrono)
	{
		$chrono = strtolower($chrono);

		$dict = [
			'year' => [1,2,3,4,5,6,7,8,9,10,11,12],
			'winter' => [12,1,2],
			'spring' => [3,4,5],
			'summer' => [6,7,8],
			'fall' => [9,10,11],
			'january' => [1],
			'february' => [2],
			'march' => [3],
			'april' => [4],
			'may' => [5],
			'june' => [6],
			'july' => [7],
			'august' => [8],
			'september' => [9],
			'october' => [10],
			'november' => [11],
			'december' => [12]
		];

		return $dict[$chrono];
	}
}
