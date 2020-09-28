<?php

namespace App\ProjectModels;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChronoConnectionPivot extends Pivot
{
    protected $table = 'connection_resource';
}
