<?php

namespace App\Project;

use App\Resource;
use App\ResourceAttribute;
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

    public function franklinId()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 384);
    }

    public function msId()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 127);
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

    public function season()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 138);
    }

    public function month()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 623);
    }

    public function medium()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 142);
    }

    public function manuscriptState()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 89);
    }

    public function manuscriptSetting()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 103);
    }

    public function isBound()
    {
        $attribute = ResourceAttribute::find(103);
        $manuscriptSetting = $this->manuscriptSetting;

        if (! $manuscriptSetting) {
            return false;
        }

        return collect($attribute->getOptionBlockItems($attribute->optionBlocks->first()))
            ->contains($manuscriptSetting->value);
    }

    public function isUnbound()
    {
        return ! $this->isBound();
    }

    public function isRetained()
    {
        $attribute = ResourceAttribute::find(103);

        if (! $this->manuscriptSetting) {
            return false;
        }

        return $this->manuscriptSetting->value != 'Sent';
    }

    public function wasSent()
    {
        return ! $this->isRetained();
    }

    public function wasCirculated()
    {
        return $this->circulation;
    }

    public function circulation()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 113);
    }

    public function enclosures()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 100);
    }

    public function custody()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 116);
    }

    public function placeholder()
    {
        return $this->hasOne(ResourceMeta::class, 'resource_id')
            ->where('resource_attribute_id', 149);
    }

    public function getFirstlineStrippedAttribute()
    {
        return preg_replace('/\s\s+/', ' ',
            strtolower(
                preg_replace('/[^A-Za-z0-9 ]/', '', $this->firstLine->value)
            )
        );
    }

    public function scopeByTranscriptionText($query, $transcriptionQuery)
    {
        $transcriptions = Transcription::where('value', 'regexp', '\\b' . $transcriptionQuery . '\\b')->get();

        return $query->whereIn('id', $transcriptions->pluck('resource_id'));
    }

    public function scopeHasBirds($query)
    {
        return $query->whereDoesntHave('meta', function ($query) {
            $query->where('resource_attribute_id', 624);
        });
    }

    public function scopeDoesntHaveBirds($query)
    {
        return $query->whereHas('meta', function ($query) {
            $query->where('resource_attribute_id', 624);
        });
    }

    public function doesMentionBirds()
    {
        return is_null($this->firstMetaByAttribute(624))
            ? true
            : false;
    }
}
