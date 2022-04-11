<?php

use App\ResourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

        $resourceTypes->each(function ($rt) {
            $rt->mainAttributes->each(function ($a) use ($rt) {
                $rt->attributes()->firstOrCreate([
                    'key' => $a->key,
                    'type' => $a->type ?? null,
                ]);
            });
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
