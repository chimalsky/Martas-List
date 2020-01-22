<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectResourceTypesToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_types', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')
                ->references('id')->on('projects');
        });
    }
}
