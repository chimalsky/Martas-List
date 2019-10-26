<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ResourceAttribute extends Model
{
    protected $table = 'resource_type_attributes';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($attribute) {
            $attribute->key = Str::snake($attribute->key);
        });
        
    }

    public function getNameAttribute()
    {
        return str_replace('_', ' ', Str::title($this->key));
    }
}
