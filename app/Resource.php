<?php

namespace App;

use App\Resource;
use App\Encoding;
use App\Connection;
use App\ResourceType;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Resource extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = ['id'];

    public function definition()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function meta()
    {
        return $this->hasMany(ResourceMeta::class)
            ->orderBy('key', 'desc');
    }

    public function resources()
    {
        return $this->connections()->with(['resources' => function($query) {
            $query->where('resource_id', '<>', $this->id);
        }]); 

        //return $this->belongsToMany(Resource::class, 'resource_resource', 'resource_a_id', 'resource_b_id')
        //   ->orderBy('name', 'desc');
    }

    public function connections()
    {
        return $this->belongsToMany(Connection::class);
    }

    public function encodings()
    {
        return $this->belongsToMany(Encoding::class);
    }

    public function scopeType($query, $type)
    {
        return $query->where('resource_type_id', $type);
    }
}
