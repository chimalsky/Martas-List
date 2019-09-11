<?php 
namespace App\Traits;

use Str;
use App\Temporality;
use App\ResourceMeta;

trait IsTemporal 
{   
    public function temporalities()
    {
        return $this->hasMany(Temporality::class);
    }
}