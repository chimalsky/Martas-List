<?php 
namespace App\Traits;

use Str;
use App\ResourceMeta;

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