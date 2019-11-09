<?php

namespace App;

use App\Resource;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ResourceMeta extends Model
{
    protected $guarded = ['id'];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($meta) {
            $meta->key = Str::snake($meta->key);
        });
    }
    
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function resourceAttribute()
    {
        return $this->belongsTo(ResourceAttribute::class, 'resource_attribute_id');
    }

    public function getNameAttribute()
    {
        return str_replace('_', ' ', Str::title($this->key));
    }
}
