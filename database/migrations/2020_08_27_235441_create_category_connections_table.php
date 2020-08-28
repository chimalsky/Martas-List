<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_connections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained('resource_categories')
                ->onDelete('cascade');

            $table->foreignId('resource_id')->constrained('resources')
                ->onDelete('cascade');

            $table->timestamps();
        });

        $oldBirdsType = \App\ResourceType::find(2);

        $oldBirds = $oldBirdsType->resources;
        $oldCategories = $oldBirdsType->categories;

        $oldCategories->each(function($cat, $index) {
            $manuscripts = $cat->resources->pluck('resources')->flatten()
            ->unique('id')
            ->filter(function($r) {
                return $r->resource_type_id === 3;
            });
        
            $newCat = \App\ResourceType::find(19)->categories()->firstWhere('name', $cat->name);
            
            $newCat->connections()->sync($manuscripts->pluck('id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_connections');
    }
}
