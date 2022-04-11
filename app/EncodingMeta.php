<?php

namespace App;

use App\Encoding;
use Illuminate\Database\Eloquent\Model;

class EncodingMeta extends Model
{
    protected $guarded = ['id'];

    public function encoding()
    {
        return $this->belongsTo(Encoding::class);
    }
}
