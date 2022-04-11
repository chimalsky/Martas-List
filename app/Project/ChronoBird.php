<?php

namespace App\Project;

use App\ResourceMeta;
use Illuminate\Database\Eloquent\Builder;

class ChronoBird extends Bird
{
    const resource_type_ids = [8, 14, 15];

    const presence_meta_ids = [538, 565, 574]; // 8 - clark 19th, 14 - bagg 20th, 15 -- mass 21st

    protected $table = 'resources';

    protected static function booted()
    {
        static::addGlobalScope('resource_type', function (Builder $builder) {
            $builder->where('resource_type_id', '<>', Bird::$resource_type_id);
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
            ->whereIn('resource_attribute_id', self::presence_meta_ids);
    }

    public static function nineteenthCenturyResourceType()
    {
        return collect(self::resource_type_ids)->first();
    }

    public static function twentiethCenturyResourceType()
    {
        return collect(self::resource_type_ids)->slice(1)->first();
    }

    public static function twentyFirstCenturyResourceType()
    {
        return collect(self::resource_type_ids)->slice(2)->first();
    }

    public static function nineteenthCenturyPresence()
    {
        return collect(self::presence_meta_ids)->first();
    }

    public static function twentiethCenturyPresence()
    {
        return collect(self::presence_meta_ids)->slice(1)->first();
    }

    public static function twentyFirstCenturyPresence()
    {
        return collect(self::presence_meta_ids)->slice(2)->first();
    }
}
