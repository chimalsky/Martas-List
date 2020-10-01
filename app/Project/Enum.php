<?php

namespace App\Project;

use ReflectionClass;

class Enum
{
    public static function getConstants()
    {
        // "static::class" here does the magic
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }

    static function getConstant($const)
    {
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstant($const); 
    }
}