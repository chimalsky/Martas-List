<?php

namespace App;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use SpatialTrait;

    protected $fillable = [
        'name',
    ];

    protected $spatialFields = [
        'location',
        'area',
    ];
}
