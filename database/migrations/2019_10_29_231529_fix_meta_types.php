<?php

use App\ResourceMeta;
use App\ResourceAttribute;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixMetaTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rm = ResourceMeta::whereNull('type');
        $ra = ResourceAttribute::whereNull('type');

        $rm->update(['type' => 'default']);
        $ra->update(['type' => 'default']);
        
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
