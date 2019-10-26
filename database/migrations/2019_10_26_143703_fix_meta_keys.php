<?php

use App\ResourceMeta;
use App\ResourceType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixMetaKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*$transcriptionsArchive = ResourceType::find(4);
        $transcriptions = $transcriptionsArchive->resources;
        
        $transcriptions->each(function($t) {
            var_dump($t->meta->pluck('key'));
        }); */

        $meta = ResourceMeta::where('id', '>', 0)->get(); 
        $meta->each(function($m) {
            $meta->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
