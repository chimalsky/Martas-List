<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryConnection extends Pivot
{
    protected $table = 'category_connections';

    public function category()
    {
        return $this->belongsTo(ResourceCategory::class);
    }
}
