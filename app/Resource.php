<?php

namespace App;

use Str;
use App\Connection;
use App\Project\Transcription;
use App\ResourceType;
use App\Traits\HasMeta;
use App\Traits\IsSeasonal;
use App\Traits\IsTemporal;
use App\Traits\HasCitations;
use App\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Resource extends Model implements HasMedia
{
    use HasMeta, IsSeasonal, IsTemporal, 
        HasCitations, HasMediaTrait,
        \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $guarded = ['id'];

    public function definition()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function parent()
    {
        return $this->belongsTo(Resource::class, 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo(ResourceCategory::class, 'resource_category_id');
    }

    public function children()
    {
        return $this->hasMany(Resource::class, 'parent_id');
    }

    // TODO : figure out how to do this dynamically
    public function transcription()
    {
        return $this->hasOne(Transcription::class);
    } 

    public function queriedMeta()
    {
        return $this->belongsTo(ResourceMeta::class);
    }

    public function queryableMeta()
    {
        return $this->belongsTo(ResourceMeta::class, 'queryable_meta_id');
    }

    public function getMetaTagsAttribute()
    {
        $keyNames = $this->definition->attributes()->pluck('key')->toArray();

        return $this->meta()->whereNotIn('key', $keyNames)->get();
    }

    public function getMainMetaAttribute()
    {
        $keyNames = $this->definition->attributes()->pluck('key')->toArray();

        return $this->meta()->whereIn('key', $keyNames)
            ->get();
    }

    public function connections()
    {
        return $this->belongsToMany(Connection::class, 'connection_resource', 'resource_id')
            ->with(['resources' => function($query) {
                $query->where('resource_id', '<>', $this->id);
            }]);
    }

    public function categories()
    {
        return $this->belongsToMany(ResourceCategory::class, 'category_connections', 'resource_id', 'category_id')
            ->using(CategoryConnection::class);
    }

    public function metaByAttribute($resourceAttribute)
    {
        $attributeId = is_int($resourceAttribute) ? $resourceAttribute : $resourceAttribute->id;

        return $this->meta->where('resource_attribute_id', $attributeId);
    }

    public function firstMetaByAttribute($resourceAttribute)
    {
        $attributeId = is_int($resourceAttribute) 
            ? $resourceAttribute 
            : $resourceAttribute->id;

        return $this->meta->firstWhere('resource_attribute_id', $attributeId);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->width(320)
              ->sharpen(10);
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

    public function getConnectedResourcesIdsAttribute()
    {
        return $this->connections->pluck('resources')->flatten()->pluck('id');
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

    public function getCategoryIdAttribute()
    {
        return $this->resource_category_id;
    }

    /**
     *  Methods 
     */

    public function syncConnectionWithResource(Resource $otherResource)
    {
        if ($this->getConnectionWithResource($otherResource)) {
            return $this->disconnectFromResource($otherResource);
        }

        $this->connectWithResource($otherResource);
    }

    public function getConnectionWithResource(Resource $otherResource)
    {
        return $this->connections()->whereHas('resources', function(Builder $query) use ($otherResource) {
            $query->where('resource_id', $otherResource->id);
        })->first();
    }

    public function connectWithResource(Resource $otherResource)
    {
        $connection = $this->connections()->create([]);

        $connection->resources()->attach($otherResource);
    }

    public function disconnectFromResource(Resource $otherResource)
    {
        $connection = $this->getConnectionWithResource($otherResource);

        $connection->delete();
    }

    public function scopeType($query, $type)
    {
        return $query->where('resource_type_id', $type);
    }

    public function scopeWithHeadlineValue($query, $metaId)
    {
        return $query->addSelect(['headline_value' => function($subQuery) use ($metaId) {
            $subQuery->select('value')
                ->from('resource_metas')
                ->whereColumn('resource_id', 'resources.id')
                ->where('resource_attribute_id', $metaId)
                ->latest()->take(1);
            }]);
    }

    public function scopeWithDynamicValue($query, $metaId, $keyName)
    {
        return $query->addSelect([$keyName => function($subQuery) use ($metaId) {
            $subQuery->select('value')
                ->from('resource_metas')
                ->whereColumn('resource_id', 'resources.id')
                ->where('resource_attribute_id', $metaId)
                ->latest()->take(1);
            }]);
    }

    public function scopeWithQueryableMeta($query, $queryableId)
    {
        return $query->addSelect(['queryable_meta_id' => function($subQuery) use ($queryableId) {
            $subQuery->select('id')
                ->from('resource_metas')
                ->whereColumn('resource_id', 'resources.id')
                ->where('resource_attribute_id', $queryableId)
                ->latest()->take(1);
            }])
            ->with('queryableMeta');
    }

    public function scopeWithQueryableMetaValue($query, $queryableId)
    {
        // Hotfix for being able to search first-line text without punctuation.
        $value = ($queryableId === 84)
            ? 'searchable_index'
            : 'value';

        return $query->addSelect(['queryable_meta_value' => function($subQuery) use ($queryableId, $value) {
            $subQuery->select($value)
                ->from('resource_metas')
                ->whereColumn('resource_id', 'resources.id')
                ->where('resource_attribute_id', $queryableId)
                ->latest()->take(1);
            }]);
    }

    public function scopeWithFilterableValues($query, ResourceAttribute $filterable, $values)
    {
        return $query->whereHas('meta', function ($query) use ($filterable, $values) {
            if (count($values) === 1 
                && $filterable->hasOptionBlock($values[0])
                ) {
                $values = $filterable->getOptionBlockItems($values[0]);
            }

            $query = $query->where('resource_attribute_id', $filterable->id)
                ->whereIn('value', $values);
        });
    }
}
