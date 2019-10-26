<?php

use App\ResourceType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertOldAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resourceTypes = ResourceType::whereNotNull('extra_attributes')->get();

        $resourceTypes->each(function($rt) {
            $rt->mainAttributes->each(function($a) use ($rt) {
                $rt->attributes()->create([
                    'key' => $a->key,
                    'type' => $a->type ?? null
                ]);
            });
        });

        dd('hi');
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
