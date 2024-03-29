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

    public static function getConstant($const)
    {
        $reflectionClass = new ReflectionClass(static::class);

        return $reflectionClass->getConstant($const);
    }

    /**
     * Get the constant name itself when you have the value.
     * Note: this will only work when values are unique
     *
     * @param  mixed  $value
     * @return  string
     */
    public static function getConstantNameByValue($value)
    {
        $flippedConstants = array_flip(static::getConstants());

        if (! array_key_exists($value, $flippedConstants)) {
            return null;
        }

        return $flippedConstants[$value];
    }
}
