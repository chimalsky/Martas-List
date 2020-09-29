<?php

namespace App\Project;

use ReflectionClass;

class SeasonEnum
{
    const SPRING = [3,4,5];
    const SUMMER = [6,7,8];
    const FALL = [9,10,11];
    const WINTER = [12,1,2];

    public static function getConstants()
    {
        // "static::class" here does the magic
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}