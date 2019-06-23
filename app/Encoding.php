<?php

namespace App;

use App\EncodingMeta;
use Illuminate\Database\Eloquent\Model;

class Encoding extends Model
{
    protected $guarded = ['id'];
    
    public function meta()
    {
        return $this->hasMany(EncodingMeta::class);
    }
}
