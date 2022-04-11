<?php

namespace App;

use App\Resource;
use App\Traits\HasCitations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class ResourceMeta extends Model
{
    use HasCitations;
    use LogsActivity;

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

    protected static function booted()
    {
        // This causes a connection refused error
        //static::addGlobalScope(new AttributeOptionValueScope);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function resourceAttribute()
    {
        return $this->belongsTo(ResourceAttribute::class, 'resource_attribute_id');
    }

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class);
    }

    public function getNameAttribute()
    {
        if (! $this->key) {
            return $this->resourceAttribute->name;
        }

        return str_replace('_', ' ', Str::title($this->key));
    }

    public function getIsLongAttribute()
    {
        return strlen($this->value) > 100;
    }

    public function getValueAttribute($value)
    {
        if ($this->attribute_option_value) {
            return $this->attribute_option_value;
        }

        return $value;
    }
}
