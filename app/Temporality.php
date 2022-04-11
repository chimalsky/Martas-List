<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Temporality extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    private $precisionFormats = [
        1 => 'Y',
        2 => 'F Y',
        3 => 'F d, Y',
        4 => 'F d, Y',
    ];

    public function getStartEnglishAttribute()
    {
        $precision = $this->start_precision ?? 4;
        $date = new Carbon($this->start);

        return $date->format($this->precisionFormats[$precision]);
    }

    public function getEndEnglishAttribute()
    {
        $precision = $this->end_precision ?? 4;
        $date = new Carbon($this->end);

        return $date->format($this->precisionFormats[$precision]);
    }
}
