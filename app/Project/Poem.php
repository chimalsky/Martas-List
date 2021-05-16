<?php

namespace App\Project;

use App\Resource as ResourceModel;
use Illuminate\Database\Eloquent\Builder;

class Poem extends ResourceModel
{
    const resource_type_id = 3;

    protected $table = 'resources';

    protected static function booted()
    {
        static::addGlobalScope('resource_type', function (Builder $builder) {
            $builder->where('resource_type_id', self::resource_type_id);
        });
    }

    public function transcription()
    {
        return $this->hasOne(Transcription::class, 'resource_id', 'asdf');
    } 
}
