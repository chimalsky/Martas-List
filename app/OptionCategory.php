<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class OptionCategory extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = ['id'];

    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'category_id')
            ->orderBy('order_column');
    }

    public function attribute()
    {
        return $this->belongsTo(ResourceAttribute::class, 'attribute_id');
    }
}
