<?php

namespace App;

use Str;
use App\Resource;
use App\Encoding;
use App\Connection;
use App\ResourceType;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Resource extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = ['id'];

    public function definition()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function meta()
    {
        return $this->hasMany(ResourceMeta::class)
            ->whereNotIn('key', ['transcription', 'encoding'])
            ->orderBy('key', 'desc');
    }

    public function mainMeta()
    {
        return $this->hasMany(ResourceMeta::class)
            ->whereIn('key', ['transcription', 'encoding']);
    }
    
    public function connections()
    {
        return $this->belongsToMany(Connection::class)->with(['resources' => function($query) {
            $query->where('resource_id', '<>', $this->id);
        }]);
    }

    public function getExcerptAttribute()
    {
        $mainFields = $this->mainMeta;

        if (! $mainFields->count()) {
            return;
        }

        $mainField = $mainFields->first();

        if ($mainField->type == 'rich-text') {
            $html = $mainField->value;
            $value = strip_tags($html);
        } else {
            $value = $mainField->value;
        }

    
        return Str::limit($value, 70);
    }

    public function getResourcesAttribute()
    {
        $connections = $this->connections()->with(['resources' => function($query) {
            $query->where('resource_id', '<>', $this->id);
        }]);

        return $connections->get()->pluck('resources')->flatten();
    } 

    public function getConnectedTypesAttribute()
    {
        return ResourceType::whereIn('id', $this->resources->pluck('resource_type_id'))->get();
    }

    public function encodings()
    {
        return $this->belongsToMany(Encoding::class);
    }

    public function scopeType($query, $type)
    {
        return $query->where('resource_type_id', $type);
    }
}
