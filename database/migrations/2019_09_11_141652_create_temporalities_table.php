<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->unsignedBigInteger('resource_id')
                ->references('id')->on('resources')
                ->onDelete('cascade');

            $table->date('start')->nullable();
            $table->unsignedTinyInteger('start_precision')->nullable();

            $table->date('end')->nullable();
            $table->unsignedTinyInteger('end_precision')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporalities');
    }
}
