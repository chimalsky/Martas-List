<?php

namespace App\Project;

use App\CategoryConnection;
use App\Resource;
use App\ResourceCategory;
use App\ResourceMeta;
use Illuminate\Database\Eloquent\Model;

class DickinsonsBird extends ResourceCategory
{
    protected $table = 'resource_categories';

    const seasonIds = [
        538, // clarks
        574, // MA Audubon
    ];

    public function birds()
    {
        return $this->hasMany(Bird::class, 'resource_category_id');
    }

    public function getSeasonsAttribute()
    {
        $birdIds = $this->birds->pluck('id');

        return ResourceMeta::whereIn('resource_attribute_id', self::seasonIds)
            ->whereIn('resource_id', $birdIds);
    }
}
