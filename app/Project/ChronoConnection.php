<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Model;

class ChronoConnection extends Model
{
    protected $table = 'connections';

    public function birds() 
    {
        return $this->hasMany(ChronoBird::class, 'id', 'pivot.resource_id');
    }

    public function getResourceAttribute()
    {
        return $this->birds->first();
    }

    public function otherBird()
    {
        return $this->belongsTo(ChronoBird::class, 'other_bird_id')
            ->with(['presenceMeta' => function($query) {
                $query->whereIn('resource_attribute_id', ChronoBird::presence_meta_ids);
            }]);
    }

    public function primaryBird()
    {
        return $this->belongsTo(Bird::class, 'primary_bird_id');
    }

    public function scopeWithOtherBirdId($query)
    {
        // Foobar: The latest('resource_id') only works because the primary bird 
        // archive was added first. This is not a permanent solution.

        return $query->addSelect(['other_bird_id' =>  ChronoConnectionPivot::select('resource_id')
                ->whereColumn('connection_id', 'connections.id')
                ->latest('resource_id')->take(1)
            ]);
    }

    public function scopeWithPrimaryBirdId($query)
    {
        return $query->addSelect(['primary_bird_id' =>  ChronoConnectionPivot::select('resource_id')
            ->whereColumn('connection_id', 'connections.id')
            ->oldest('resource_id')->take(1)
        ]);
    }
}
