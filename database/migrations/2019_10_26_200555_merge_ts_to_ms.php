<?php

use App\ResourceType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergeTsToMs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $transcriptionsArchive = ResourceType::find(4);
        $transcriptions = $transcriptionsArchive->resources;

        
        $transcriptions->map(function($t) {
            $manuscripts = $t->connections->pluck('resource')->filter(function($resource) {
                if (!$resource) { return; }

                return $resource->resource_type_id == 3;
            })->each(function($manuscript) use ($t) {
                $params = $t->meta->map(function($meta) {
                    return [
                        'key' => $meta->key,
                        'value' => $meta->value
                    ];
                })->toArray();

                $manuscript->meta()->createMany($params);
            });
        });

    }
}
