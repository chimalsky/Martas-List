<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ConnectionResource extends Pivot
{
    use \Staudenmeir\EloquentHasManyDeep\HasTableAlias;
}
