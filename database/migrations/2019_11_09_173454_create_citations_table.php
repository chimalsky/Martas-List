<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('citation');

            $table->timestamps();
        });

        Schema::create('citeables', function (Blueprint $table) {
            $table->unsignedBigInteger('citation_id')
                ->references('id')->on('citations')
                ->onDelete('cascade');

            $table->morphs('citeable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citations');
    }
}
