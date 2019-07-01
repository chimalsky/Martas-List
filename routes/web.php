<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('encodings.index');
});

Route::resource('encodings', 'EncodingsController');

Route::resource('encoding.metas', 'EncodingMetasController');
Route::resource('encoding.resources', 'EncodingResourcesController');

Route::resource('resources', 'ResourcesController');
Route::resource('resource-types', 'ResourceTypesController');

Route::resource('resource.metas', 'ResourceMetasController');
Route::resource('resource.media', 'ResourceMediaController');

