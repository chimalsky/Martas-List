<?php

namespace App\Http\Livewire\Project\DigitalObjects;

use App\ResourceType;
use App\Project\Bird;
use Livewire\Component;
use App\Project\MonthEnum;
use App\Project\ChronoBird;
use Illuminate\Support\Str;

class BirdRing extends Component
{
    public $months;
    public $activeMonth;

    public $activeChrono = 19;
    
    public function mount()
    {
        $this->months = MonthEnum::getConstants();

        $currentMonth = Str::upper(now()->format('F'));
        
        $this->activeMonth = MonthEnum::getConstant($currentMonth);
    }

    public function getPreviousMonthProperty()
    {
        if ($this->activeMonth == MonthEnum::JANUARY) {
            return MonthEnum::DECEMBER;
        }
        
        return $this->activeMonth - 1;
    }

    public function getChronoResourceTypeProperty()
    {
        $chronoDict = [
            '19' => ChronoBird::nineteenthCenturyResourceType(),
            '20' => ChronoBird::twentiethCenturyResourceType(),
            '21' => ChronoBird::twentyFirstCenturyResourceType()
        ];

        return ResourceType::firstWhere('id', $chronoDict[$this->activeChrono]);
    }

    public function getChronoBirdsProperty()
    {
        return $this->chronoResourceType->resources();
    }

    public function getNewArrivals()
    {
        $chronoBirds = $this->chronoBirds;

        $filteredBirdsByPresence = $chronoBirds
            ->withDynamicValue(538, 'presence')
            ->get()
            ->filter(function($bird) {
                $months = collect(array_map('trim', explode(',', $bird->presence)));

                if ($months->contains($this->previousMonth)) {
                    return false;
                }

                return $months->contains($this->activeMonth);
            });

        return $filteredBirdsByPresence;
    }

    public function getLingerers()
    {
        $chronoBirds = $this->chronoBirds;

        $filteredBirdsByPresence = $chronoBirds
            ->withDynamicValue(538, 'presence')
            ->get()
            ->filter(function($bird) {
                $months = collect(array_map('trim', explode(',', $bird->presence)));

                if (!$months->contains($this->previousMonth)) {
                    return false;
                }

                return $months->contains($this->activeMonth);
            });

        return $filteredBirdsByPresence;
    }

    public function getMigrants()
    {

    }

    public function getBirds()
    {
        $presenceBirdConnections = $this->getPresenceConnections();

        $filteredBirdsByPresence = $presenceBirdConnections
            ->filter(function($connection) {
                $bird = $connection->otherBird;

                $presence = $bird->presenceMeta->value;

                $months = collect(array_map('trim', explode(',', $presence)));
                
                if ($months->contains($this->activeMonth)) {
                    return true;
                }
            });

        return Bird::whereIn('id', $filteredBirdsByPresence->pluck('primary_bird_id'));
    }

    public function render()
    {
        //$this->birds = $this->getBirds()->get();

        $birds = $this->getNewArrivals()->merge($this->getLingerers());

        $groupedBirds = $birds->sortBy('name')->split(4);

        return view('livewire.project.digital-objects.bird-ring', compact('groupedBirds'));
    }
}
