<?php

namespace App;

use App\Encoding;
use App\ResourceType;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Resource extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = ['id'];

    public function definition()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }

    public function meta()
    {
        return $this->hasMany(ResourceMeta::class);
    }

    public function encodings()
    {
        return $this->belongsToMany(Encoding::class);
    }

    public function scopeType($query, $type)
    {
        return $query->where('resource_type_id', $type);
    }
}
