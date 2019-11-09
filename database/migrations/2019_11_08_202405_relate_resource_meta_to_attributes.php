<?php

use App\ResourceMeta;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelateResourceMetaToAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resourceMeta = ResourceMeta::all();

        $resourceMeta->each(function($m) {
            if ($m->resource->definitionAttributes->pluck('key')->contains($m->key)) {                
                $attribute = $m->resource->definitionAttributes->firstWhere('key', $m->key);

                $m->resourceAttribute()->associate($attribute); 
                $m->save();               
            }
        });
    }
}
