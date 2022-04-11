<?php

use App\Connection;
use App\Encoding;
use App\Resource;
use App\ResourceMeta;
use App\ResourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertEncodingsToResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resourceType = ResourceType::create([
            'name' => 'Poems',
        ]);

        $encodings = Encoding::all();

        $encodings->each(function ($encoding) use ($resourceType) {
            $resource = $resourceType->resources()->create([
                'name' => $encoding->encoder_assigned_id,
            ]);

            $metaParams = $encoding->meta->map(function ($meta) {
                return [
                    'key' => $meta->key,
                    'value' => $meta->value,
                    'created_at' => $meta->created_at,
                    'updated_at' => $meta->updated_at,
                ];
            })->toArray();

            $resource->meta()->createMany($metaParams);

            $resourceIds = $encoding->resources->pluck('id')->toArray();

            $encoding->resources->each(function ($oldResource) use ($resource) {
                $connection = Connection::create();

                $connection->resources()->attach($oldResource->id);
                $connection->resources()->attach($resource->id);
            });
        });
    }
}
