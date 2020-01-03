<?php

namespace App;

use App\Resource;
use Illuminate\Support\Str;
use App\Traits\HasCitations;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ResourceMeta extends Model
{
    use HasCitations, LogsActivity;
    
    protected $guarded = ['id'];

    protected static $logName = 'resource_meta';
    protected static $logAttributes = ['value', 'key'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($meta) {
            $meta->key = Str::snake($meta->key);
        });
    }
    
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function resourceAttribute()
    {
        return $this->belongsTo(ResourceAttribute::class, 'resource_attribute_id');
    }

    public function getNameAttribute()
    {
        return str_replace('_', ' ', Str::title($this->key));
    }

    public function getIsLongAttribute()
    {
        return strlen($this->value) > 100;
    }
}
