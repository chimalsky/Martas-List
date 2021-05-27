<?php

namespace App\Project;

use App\ResourceMeta;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Transcription extends ResourceMeta
{
    use Searchable;

    protected $table = 'resource_metas';

    protected static function booted()
    {
        static::addGlobalScope('resource_attribute_id', function (Builder $builder) {
            $builder->where('resource_attribute_id', 78);
        });
    }

    public function toSearchableArray()
    {
        return[
            'text' => html_entity_decode(strip_tags($this->value))
        ];
    }
}