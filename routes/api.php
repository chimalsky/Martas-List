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
    $manuscripts = \App\Resource::with('meta')->where('resource_type_id', 3)
        ->get();
    
    $yearAttribute = \App\ResourceAttribute::Find(131);
    $seasonAttribute = \App\ResourceAttribute::Find(138);
    $idAttribute = \App\ResourceAttribute::Find(127);
    $firstLine = \App\ResourceAttribute::Find(84);

    $payload = [];

    foreach ($manuscripts as $manuscript) {
        array_push($payload, $manuscript);
    }

    return [
        'data' => $payload
    ];

    dd($manuscripts->first()->metaByAttribute($seasonAttribute)->first()->value);

});