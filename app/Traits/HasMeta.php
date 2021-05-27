<?php 

namespace App\Traits;

use App\ResourceMeta;

trait HasMeta
{
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
}