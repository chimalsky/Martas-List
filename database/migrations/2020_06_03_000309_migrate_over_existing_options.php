<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateOverExistingOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $attributes = \App\ResourceAttribute::select('id', 'options')->whereNotNull('options')
            ->get();

        $attributes->each(function($attribute) {
            if (is_array($attribute->options)) {
                foreach ($attribute->options as $option) {
                    if (is_array($option)) {
                        dump($option['_name']);

                        $category = $attribute->categories()->firstOrCreate(
                            ['attribute_id' =>  $attribute->id, 'name' => $option['_name']]
                        );

                        foreach ($option['_items'] as $item) {
                            $category->options()->firstOrCreate(
                                ['value' => $item, 'attribute_id' => $attribute->id]
                            );
                        }
                    } else {
                        if (is_null($option)) {
                            continue;
                        }

                        \App\AttributeOption::firstOrCreate(
                            ['value' => $option, 'attribute_id' => $attribute->id]
                        );
                       // dump($option);
                    }
                    //dump($attribute->id); dump($option);
                }
            }
        });

        dd('do it again later');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
