<?php

namespace App;

use Str;
use App\Resource;
use App\EncodingMeta;
use App\EncodingResource;
use Illuminate\Database\Eloquent\Model;

class Encoding extends Model
{
    protected $guarded = ['id'];
    
    public function meta()
    {
        return $this->hasMany(EncodingMeta::class);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class)
            ->orderBy('name', 'desc');
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->encoding, 100);
    }
}
