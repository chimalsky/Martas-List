<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchableIndexToResourceMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_metas', function (Blueprint $table) {
            $table->text('searchable_index')->nullable();
        });

        // migrate over current transcriptions + first-line meta

        $meta = App\ResourceAttribute::find(78)->meta;
        $meta2 = App\ResourceAttribute::find(84)->meta;

        $meta->each(function ($m) {
            $html = new \Html2Text\Html2Text($m->value);
            $text = $html->getText();

            $stripped = preg_replace('/[^\da-z\s]/i', '', $text);

            $m->update(['searchable_index' => $stripped]);
        });

        $meta2->each(function ($m) {
            $html = new \Html2Text\Html2Text($m->value);
            $text = $html->getText();

            $stripped = preg_replace('/[^\da-z\s]/i', '', $text);

            $m->update(['searchable_index' => $stripped]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_metas', function (Blueprint $table) {
            $table->dropColumn('searchable_index');
        });
    }
}
