<?php

namespace App\Project;

use App\Resource;
use App\ResourceMeta;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Models\Media;

class Poem extends Resource
{
    public static $resource_type_id = 3;

    protected $table = 'resources';

    protected static function booted()
    {
        static::addGlobalScope('resource_type', function (Builder $builder) {
            $builder->where('resource_type_id', self::$resource_type_id);
        });
    }

    public function newCollection(array $models = [])
    {
        return new PoemCollection($models);
    }

    public function birdCategories()
    {
        return $this->categories()->where('resource_type_id', Bird::$resource_type_id);
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

    public function firstLine()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 84);
    }

    public function year()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 131);
    }

    public function placeholder()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 149);
    }

    public function getFirstlineStrippedAttribute()
    {
        return strtolower(
            preg_replace("/[^A-Za-z0-9 ]/", '', $this->firstLine->value)
        );
    }

    public function scopeByTranscriptionText($query, $transcriptionQuery)
    {
        $transcriptions = Transcription::search($transcriptionQuery)->get();

        return $query->whereIn('id', $transcriptions->pluck('resource_id'));
    }

    public function scopeHasBirds($query)
    {
        return $query->whereDoesntHave('meta', function($query) {
            $query->where('resource_attribute_id', 624);
        });
    }

    public function scopeDoesntHaveBirds($query)
    {
        return $query->whereHas('meta', function($query) {
            $query->where('resource_attribute_id', 624);
        });
    }

    public function doesMentionBirds()
    {
        return $this->firstMetaByAttribute(624)
            ? false 
            : true;
    }

}
