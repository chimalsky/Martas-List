<?php

namespace App;

use Str;
use App\Resource;
use App\ResourceAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;


class ResourceType extends Model
{
    protected $guarded = ['id'];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public function resources()
    {
        return $this->hasMany(Resource::class, 'resource_type_id')
            ->orderBy('name', 'asc');
    }

    public function attributes()
    {
        return $this->hasMany(ResourceAttribute::class);
    }

    public function getMainAttributesAttribute()
    {
        $attributes = collect($this->extra_attributes->get('attributes', []));
        return $attributes->mapInto(ResourceAttribute::class);
    }

    public function getNameSingularAttribute()
    {
        return Str::singular($this->name);
    }

    public function getExtraAttributesAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'extra_attributes');
    }

    public function scopeWithExtraAttributes(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('extra_attributes');
    }

}
