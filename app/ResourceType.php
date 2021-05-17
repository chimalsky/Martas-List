<?php

namespace App;

use Str;
use App\Resource;
use App\ResourceAttribute;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\SchemalessAttributes\SchemalessAttributes;

class ResourceType extends Model implements Sortable
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use SortableTrait;

    protected $guarded = ['id'];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public $availableTypes = [
        'default' => 'Regular attribute type -- same as tags',
        'dropdown' => 'Dropdown List',
        'rich-text' => 'Rich Text', 
        'encoding' => 'encoding',
        'link' => 'Link to another Webpage',
        'external-media__audio' => 'Audio on another Website',
        'external-media__image' => 'Image on another Website'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'resource_type_id');
    }

    public function categories()
    {
        return $this->hasMany(ResourceCategory::class);
    }

    public function allAttributes()
    {
        return $this->hasMany(ResourceAttribute::class);
    }

    public function attributes()
    {
        return $this->hasMany(ResourceAttribute::class)
            ->orderBy('order')
            ->whereNotIn('type', ['connection']);
    }

    public function connections()
    {
        return $this->hasMany(ResourceAttribute::class)
            ->where('type', 'connection');
    }

    public function metaActivities()
    {
        return $this->hasManyDeep(
            Activity::class,
            [Resource::class, ResourceMeta::class],
            [null, null, ['subject_type', 'subject_id']]
        )->with(['causer', 'subject.resource', 'subject.resourceAttribute'])
        ->inLog('resource_meta')
        ->orderBy('created_at', 'desc');
    }

    public function mediaActivities()
    {
        return $this->hasManyDeep(
            Activity::class,
            [Resource::class, ResourceMedia::class],
            [null, ['model_type', 'model_id'], ['subject_type', 'subject_id']]
        )->with(['causer', 'subject.model'])
        ->inLog('resource_media')
        ->orderBy('created_at', 'desc');
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
