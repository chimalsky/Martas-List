<?php

namespace App;

use App\Resource;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    public function resources() 
    {
        return $this->belongsToMany(Resource::class);
    }

    public function getResourceAttribute()
    {
        return $this->resources->first();
    }

}
