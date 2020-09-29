<?php

namespace App\Project;

use App\ResourceMeta;
use Illuminate\Database\Eloquent\Builder;

class ChronoBird extends Bird
{
    const resource_type_ids = [8];
    const presence_meta_ids = [538, 565, 574];

    protected $table = 'resources';

    protected static function booted()
    {
        static::addGlobalScope('resource_type', function (Builder $builder) {
            $builder->where('resource_type_id', '<>', Bird::resource_type_id);
        });
    }

    public function meta()
    {
        return $this->hasMany(ResourceMeta::class, 'resource_id')
            ->with('resourceAttribute')
            ->orderBy('key', 'desc');
    }

    public function presenceMeta()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->whereIn('resource_attribute_id', ChronoBird::presence_meta_ids);
    }
}
