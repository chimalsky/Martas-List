<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('attribute_id')->constrained('resource_type_attributes')
                ->onDelete('cascade');

            $table->unsignedSmallInteger('order_column');

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
        Schema::dropIfExists('option_categories');
    }
}
