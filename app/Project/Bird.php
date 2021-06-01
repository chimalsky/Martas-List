<?php

namespace App\Project;

use App\Resource as ResourceModel;
use App\ResourceMeta;
use Illuminate\Database\Eloquent\Builder;

class Bird extends ResourceModel
{
    public static $resource_type_id = 19;

    protected $table = 'resources';

    protected static function booted()
    {
        static::addGlobalScope('resource_type', function (Builder $builder) {
            $builder->where('resource_type_id', self::$resource_type_id);
        });
    }

    public function dickinsonsBird()
    {
        return $this->belongsTo(DickinsonsBird::class, 'resource_category_id');
    }

    public function chronoConnections()
    {
        return $this->belongsToMany(
            ChronoConnection::class, 'connection_resource', 'resource_id', 'connection_id'
        )->withOtherBirdId()
            ->withPrimaryBirdId()
            ->with('otherBird');
    }

    public function presenceMetas()
    {
        $chronoBirds = $this->chronoConnections->pluck('otherBird');

        /*return $this->meta()
            ->whereIn('resource_attribute_id', ChronoBird::presence_meta_ids)
            ->whereIn('resource_id', $chronoBirds->pluck('id'));*/

        return ResourceMeta::whereIn('resource_attribute_id', ChronoBird::presence_meta_ids)
            ->whereIn('resource_id', $chronoBirds->pluck('id'))->get();
    }

    /*public function nineteenthCenturyPresenceFoo()
    {
        return $this->belongsTo(ResourceMeta::class, 'nineteenth_century_presence_id');
    }

    public function scopeWithNineteenthCenturyPresenceFoo($query)
    {
        return $query->addSelect(['nineteenth_century_presence_id' =>  ResourceMeta::select('id')
            ->whereIn('resource_id', 'resources.id')
            ->where('resource_attribute_id', 538)
            ->latest()->take(1)
        ]);
    }*/
}
