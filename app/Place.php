<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Place extends Model
{
    use SpatialTrait;

    protected $fillable = [
        'name'
    ];

    protected $spatialFields = [
        'location',
        'area'
    ];
}
