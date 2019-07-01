<?php

namespace App;

use App\Resource;
use Illuminate\Database\Eloquent\Model;

class ResourceMeta extends Model
{
    protected $guarded = ['id'];
    
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
