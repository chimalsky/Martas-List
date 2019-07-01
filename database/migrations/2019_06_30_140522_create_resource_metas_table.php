<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('resource_id')
                ->references('id')
                ->on('encodings')
                ->onDelete('cascade');
            
            $table->string('key');
            $table->text('value');
            $table->string('type')->nullable();

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
        Schema::dropIfExists('resource_metas');
    }
}
