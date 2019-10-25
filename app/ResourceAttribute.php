<?php

namespace App;

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
        $this->name = $params['name'];
        $this->type = $params['type'];
    }

}
