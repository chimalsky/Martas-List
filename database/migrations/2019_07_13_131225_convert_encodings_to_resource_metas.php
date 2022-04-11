<?php

use App\Encoding;
use App\ResourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertEncodingsToResourceMetas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $transcripts = ResourceType::where('name', 'Poem Transcripts')->first();

        $encodings = Encoding::all();

        $encodings->each(function ($encoding) use ($transcripts) {
            $transcription = $encoding->encoding;
            $mockedEncoding = $encoding->mock_encoding;
            $name = $encoding->encoder_assigned_id;

            $resource = $transcripts->resources()->where('name', 'like', "%$name%")->first();

            if ($resource) {
                $resource->meta()->createMany([
                    [
                        'key' => 'transcription',
                        'value' => $transcription,
                        'type' => 'rich-text',
                    ],
                    [
                        'key' => 'encoding',
                        'value' => $mockedEncoding,
                        'type' => 'encoding',
                    ],
                ]);
            }
        });
    }
}
