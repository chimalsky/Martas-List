<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncodingMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encoding_metas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('encoding_id')
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
        Schema::dropIfExists('encoding_metas');
    }
}
