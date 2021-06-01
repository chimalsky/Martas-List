<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Collection;

class PoemCollection extends Collection 
{
    public function sortByFirstLine($direction = 'asc')
    {
        return $direction == 'asc' 
            ? $this->sortBy('firstlineStripped')
            : $this->sortByDesc('firstlineStripped');
    }

    public function sortByYear($direction = 'asc')
    {
        if ($direction == 'asc') {
            return $this->sortBy(function($poem) {
                if ($poem->year->value == 'Unknown') {
                    return 999999;
                }
                
                return $poem->year->value;
            });
        } 

        return $this->sortByDesc(function($poem) {
            if ($poem->year->value == 'Unknown') {
                return 999999;
            }
            
            return $poem->year->value;
        });
    }
}