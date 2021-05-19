<?php

namespace App\Project;

use App\Resource;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Models\Media;

class Poem extends Resource
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
        return $this->hasOne(Transcription::class, 'resource_id');
    } 

    public function facsimiles()
    {
        return $this->hasMany(Media::class, 'model_id', 'id')
            ->where('model_type', Resource::class);
    }

    public function scopeByTranscriptionText($query, $transcriptionQuery)
    {
        $transcriptions = Transcription::search($transcriptionQuery)->get();

        return $query->whereIn('id', $transcriptions->pluck('resource_id'));
    }
}
