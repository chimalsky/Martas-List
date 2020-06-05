<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class AttributeOption extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = ['id'];

    public function buildSortQuery()
    {
        return static::query()->where('attribute_id', $this->attribute_id);
    }

    public function category()
    {
        return $this->belongsTo(OptionCategory::class, 'category_id');
    }

}
