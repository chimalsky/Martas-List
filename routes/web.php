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

Route::get('/', 'BrochureController@index')->name('brochure.index');

Route::prefix('dearchived')->name('dearchived.')->namespace('Dearchived')->group(function () {
    Route::get('/dearchived', 'BirdController@show')->name('bird.show');
});

Route::get('/home', function() {
    return redirect()->route('resources.index');
})->name('home');

Route::get('/blog', 'BlogController@index')->name('blog.index');

Route::middleware(['auth'])->group(function() {
    Route::get('xeno-power', 'XenoController');
    
    Route::resource('encodings', 'EncodingsController');

    Route::resource('encoding.metas', 'EncodingMetasController');
    Route::resource('encoding.resources', 'EncodingResourcesController');

    Route::resource('resources', 'ResourcesController');
    Route::resource('resource-types', 'ResourceTypesController');

    Route::resource('resource-type.attributes', 'ResourceTypeAttributesController');

    Route::get('/resource-type/{resource_type}/resources/create', 'ResourceTypeResourcesController@create')
        ->name('resource-type.resources.create');

    Route::post('/resource-type/{resource_type}/resources', 'ResourceTypeResourcesController@store')
        ->name('resource-type.resources.store');
    
    Route::put('/resource-type/{resource_type}/resources/{resource}', 'ResourceTypeResourcesController@update')
        ->name('resource-type.resources.update');
    
    Route::put('/resource-type/{resource_type}/connections', 'ResourceTypeConnectionsController@update')
        ->name('resource-type.connections.update');

    Route::resource('resource.connections', 'ResourceConnectionsController');
    Route::resource('resource.metas', 'ResourceMetasController');
    Route::resource('resource.media', 'ResourceMediaController');
    Route::resource('resource.temporalities', 'ResourceTemporalitiesController');
    Route::resource('resource.lineages', 'ResourceLineagesController');

});

Auth::routes();
