<?php

namespace App;

use App\Resource;
use App\ResourceMeta;
use App\ResourceType;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

class ResourceAttribute extends Model implements Sortable
{
    use SortableTrait;
    
    protected $table = 'resource_type_attributes';
    protected $guarded = ['id'];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($attribute) {
           // $attribute->key = Str::snake($attribute->key);
        });
        
    }

    public function buildSortQuery()
    {
        return static::query()->where('resource_type_id', $this->resource_type_id);
    }

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class);
    }

    public function meta()
    {
        return $this->hasMany(ResourceMeta::class, 'resource_attribute_id');
    }

    public function categories()
    {
        return $this->hasMany(OptionCategory::class, 'attribute_id');
    }

    public function optionsObjects()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id')
            ->whereNull('category_id');
    }

    public function getNameAttribute()
    {
        return $this->key;
    }

    public function getOptionsDropdownAttribute()
    {
        return collect($this->options)->flatten()->mapWithKeys(function($option) {
            return [$option => $option];
        })->toArray();
    }
}
