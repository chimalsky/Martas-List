<?php

namespace App\Traits;

use App\ResourceMeta;
use Str;

trait IsSeasonal
{
    public function season()
    {
        return $this->belongsTo(ResourceMeta::class);
    }

    public function scopeWithSeason($query)
    {
        return $query->addSubSelect('season_id', ResourceMeta::select('id')
            ->whereColumn('resource_id', 'resources.id')
            ->where('key', 'like', '%season%')
            ->latest()
        )->with('season');
    }
}
