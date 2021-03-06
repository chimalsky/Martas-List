<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    protected $guarded = ['id'];

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function connections()
    {
        return $this->belongstoMany(Resource::class, 'category_connections', 'category_id')
            ->using(CategoryConnection::class);
    }
}
