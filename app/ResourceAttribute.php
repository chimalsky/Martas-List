<?php

namespace App;

use App\Resource;
use App\ResourceMeta;
use App\ResourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
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
        'options' => 'array',
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

    public function getTitleAttribute()
    {
        return $this->key;
    }

    public function getOptionsGroupedAttribute()
    {
        return $this->nonNullOptions->map(function ($item) {
            if (is_array($item)) {
                return $item;
            }

            return [
                '_name' => $item,
                '_items' => [],
            ];
        });
    }

    public function getNonNullOptionsAttribute()
    {
        return collect($this->options)->reject(function ($option) {
            return is_null($option);
        });
    }

    public function getNonNullOptionsFlattenedAttribute()
    {
        return $this->nonNullOptions->map(function ($item) {
            if (is_array($item)) {
                return $item['_items'];
            }

            return $item;
        })->flatten();
    }

    public function getOptionBlocksAttribute()
    {
        return $this->optionsGrouped->filter(function ($block) {
            if (! is_array($block)) {
                return false;
            }

            return count($block['_items']);
        })->pluck('_name');
    }

    public function getOptionsDropdownAttribute()
    {
        return $this->nonNullOptionsFlattened->mapWithKeys(function ($option) {
            return [$option => $option];
        })->toArray();
    }

    public function hasOption($option)
    {
        return $this->nonNullOptionsFlattened->contains($option);
    }

    public function hasOptionBlocks()
    {
        return $this->optionBlocks->count();
    }

    public function hasOptionBlock($optionBlock)
    {
        return $this->optionBlocks->contains($optionBlock);
    }

    public function getOptionBlock($optionBlock)
    {
        return $this->optionsGrouped->first(function ($group) use ($optionBlock) {
            return $group['_name'] == $optionBlock;
        });
    }

    public function getOptionBlockItems($optionBlock)
    {
        return $this->getOptionBlock($optionBlock)['_items'];
    }
}
