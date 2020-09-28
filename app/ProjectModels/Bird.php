<?php

namespace App\ProjectModels;

use App\Resource as ResourceModel;
use App\ResourceMeta;
use Illuminate\Database\Eloquent\Builder;

class Bird extends ResourceModel
{
    const resource_type_id = 19;

    protected $table = 'resources';

    protected static function booted()
    {
        static::addGlobalScope('resource_type', function (Builder $builder) {
            $builder->where('resource_type_id', self::resource_type_id);
        });
    }

    public function dickinsonsBird()
    {
        return $this->belongsTo(DickinsonsBird::class, 'resource_category_id');
    }

    public function chronoBirds()
    {
        return $this->belongsToMany(
            ChronoConnection::class, 'connection_resource', 'resource_id', 'connection_id'
        )->withBirdId();
        /*->with(['birds' => function($query) {
            //$query->where('resource_id', '<>', $this->id);
        }]); */
    }

    public function getSeasonAttribute()
    {
        return ResourceMeta::whereIn('resource_attribute_id', [538])
            ->whereIn('resource_id', $this->chronoBirds->pluck('resources')->flatten()->pluck('id'));
    }

    public function meta()
    {
        return $this->hasMany(ResourceMeta::class, 'resource_id')
            ->with('resourceAttribute')
            ->orderBy('key', 'desc');
    }

    public function firstMetaByAttribute($resourceAttribute)
    {
        $attributeId = is_int($resourceAttribute) 
            ? $resourceAttribute 
            : $resourceAttribute->id;

        return $this->meta->firstWhere('resource_attribute_id', $attributeId);
    }

    public function scopeSeasonal($query)
    {
        return $query->whereHas('season');
    }
}
