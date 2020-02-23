<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/caroline', function (Request $request) {
    $manuscripts = \App\Resource::with(['meta', 'connections'])->where('resource_type_id', 3)
        ->get();
    
    $attributes = [
        \App\ResourceAttribute::Find(131),
        \App\ResourceAttribute::Find(138),
        \App\ResourceAttribute::Find(127),
        \App\ResourceAttribute::Find(84)
    ];

    $birdsong = \App\ResourceAttribute::find(75);
    
    $payload = [];

    foreach ($manuscripts as $manuscript) {
        $row = ['birds' => []];

        foreach ($attributes as $attribute) {
            if (!$manuscript->metaByAttribute($attribute)->count()) {
            } else {
                $row[$manuscript->metaByAttribute($attribute)->first()->resourceAttribute->key] = $manuscript->metaByAttribute($attribute)->first()->value;
            }
        }

        foreach( $manuscript->resources->where('resource_type_id', 2) as $bird) {
            
            $birdSong = $bird->resources->where('resource_type_id', 6)->first();

            array_push($row['birds'], [
                'name' => $bird->name,
                'song' => $birdSong ? $birdSong->metaByAttribute($birdsong)->first()->value .'/download' : null
            ]);
        }

        array_push($payload, $row);

    }

    return response()
        ->json($payload);

});