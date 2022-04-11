<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connection_resource', function (Blueprint $table) {
            $table->foreign('connection_id')
                ->references('id')
                ->on('connections')
                ->onDelete('cascade');
            $table->foreign('resource_id')
                ->references('id')
                ->on('resources')
                ->onDelete('cascade');
        });
        /*
        Schema::table('resources', function (Blueprint $table) {
            $table->foreign('resource_type_id')
                ->references('id')
                ->on('resource_types')
                ->onDelete('cascade');
        }); */

        Schema::table('resource_metas', function (Blueprint $table) {
            $table->foreign('resource_id')
                ->references('id')
                ->on('resources')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
}
