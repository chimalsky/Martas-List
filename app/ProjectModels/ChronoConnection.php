<?php

namespace App\ProjectModels;

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
        return $this->belongsTo(ChronoBird::class, 'bird_id');
    }

    public function scopeWithBirdId($query)
    {
        return $query->addSelect(['bird_id' =>  ChronoConnectionPivot::select('resource_id')
                ->whereColumn('connection_id', 'connections.id')
                ->latest('id')->take(1)
            ]);
    }
}
