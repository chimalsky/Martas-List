<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceTypeAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_type_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('key');
            $table->string('type')->nullable();

            $table->unsignedBigInteger('resource_type_id')
                ->references('id')
                ->on('encodings')
                ->onDelete('cascade');

            $table->tinyInteger('order')->nullable();

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
        Schema::dropIfExists('resource_type_attributes');
    }
}
