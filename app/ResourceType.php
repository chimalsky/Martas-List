<?php

namespace App;

use Str;
use App\Resource;
use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    protected $guarded = ['id'];

    public function resources()
    {
        return $this->hasMany(Resource::class, 'resource_type_id');
    }

    public function getNameSingularAttribute()
    {
        return Str::singular($this->name);
    }
}
