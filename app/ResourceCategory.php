<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    protected $guarded = ['id'];

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
