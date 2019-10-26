<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ResourceAttribute extends Model
{
    protected $guarded = [];

    /**
     * Create a new Resource Attribute instance.
     *
     * @param  array  $params
     * @return void
     */
    function __construct(array $params)
    {
        $this->key = Str::snake($params['name']);
        $this->type = $params['type'];
    }


    public function getNameAttribute()
    {
        return str_replace('_', ' ', Str::title($this->key));
    }
}
