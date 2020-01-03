<?php

namespace App;

use Spatie\MediaLibrary\Models\Media;
use Spatie\Activitylog\Traits\LogsActivity;

class ResourceMedia extends Media
{
    use LogsActivity;

    protected $table = 'media';

    protected static $logName = 'resource_media';
}
