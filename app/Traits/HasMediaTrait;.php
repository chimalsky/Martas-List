<?php

namespace App\Traits;

use App\Resource;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait as SpatieMediaTrait;

trait HasMediaTrait
{
    use SpatieMediaTrait;

    public function getRandomMedia($type = null)
    {
        if ($this->hasMedia()) {
            return $this->getFirstMedia();
        }
    }
}