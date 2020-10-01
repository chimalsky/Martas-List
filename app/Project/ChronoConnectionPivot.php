<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChronoConnectionPivot extends Pivot
{
    protected $table = 'connection_resource';
}
