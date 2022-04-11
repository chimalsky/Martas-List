<?php

namespace App;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\Models\Media;

class ResourceMedia extends Media
{
    use LogsActivity;

    protected $table = 'media';

    protected static $logName = 'resource_media';
}
