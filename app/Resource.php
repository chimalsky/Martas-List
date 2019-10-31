<?php

namespace App;

use Str;
use App\Resource;
use App\Encoding;
use App\Connection;
use App\ResourceType;
use App\Traits\IsSeasonal;
use App\Traits\IsTemporal;
use App\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Resource extends Model implements HasMedia
{
    use IsSeasonal, IsTemporal, HasMediaTrait;

    protected $guarded = ['id'];

    public function definition()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function parent()
    {
        return $this->belongsTo(Resource::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Resource::class, 'parent_id');
    }

    public function meta()
    {
        return $this->hasMany(ResourceMeta::class)
            ->orderBy('key', 'desc');
    }

    public function getMetaTagsAttribute()
    {
        $keyNames = $this->definition->attributes()->pluck('key')->toArray();

        return $this->meta()->whereNotIn('key', $keyNames)->get();
    }

    public function getMainMetaAttribute()
    {
        $keyNames = $this->definition->attributes()->pluck('key')->toArray();

        return $this->meta()->whereIn('key', $keyNames)->get();
    }

    public function connections()
    {
        return $this->belongsToMany(Connection::class)
            ->with(['resources' => function($query) {
                $query->where('resource_id', '<>', $this->id);
            }]);
    }

    public function getMainAttributesAttribute()
    {
        $definition = $this->definition;
        return $definition->attributes;
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

    public function getResourcesGroupedAttribute()
    {
        return $this->resources->groupBy(function($r) {
            return $r->definition->name;
        });
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
