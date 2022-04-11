<?php

namespace App\Traits;

use App\ResourceMeta;
use App\Temporality;
use Str;

trait IsTemporal
{
    public function temporalities()
    {
        return $this->hasMany(Temporality::class);
    }
}
