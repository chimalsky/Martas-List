<?php

namespace App;

use App\EncodingMeta;
use App\EncodingResource;
use App\Resource;
use Illuminate\Database\Eloquent\Model;
use Str;

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
