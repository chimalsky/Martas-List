<?php

namespace App\Scopes;

use App\AttributeOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AttributeOptionValueScope implements Scope
{
    public function apply(Builder $query, Model $model)
    {
        $query->addSelect(['attribute_option_value' => AttributeOption::select('value')
                ->whereColumn('attribute_option_id', 'attribute_options.id')
                ->latest()
                ->take(1),
        ]);
    }
}
