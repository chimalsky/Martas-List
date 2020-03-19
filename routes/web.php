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

Route::prefix('project')->name('project.')->namespace('Project')->group(function () {
    Route::get('/', 'IndexController')->name('index');
    Route::get('/about', 'AboutController')->name('about');
    Route::get('/poems', 'PoemsController@index')->name('poems.index');
    Route::get('/poems/{poem}', 'PoemsController@show')->name('poems.show');
    
    Route::get('/birds', 'BirdsController@index')->name('birds.index');
    Route::get('/birds/{bird}', 'BirdsController@show')->name('birds.show');
});

Route::group(['middleware' => 'auth'], function() {

    Route::get('/home', function() {
        return redirect()->route('resource-types.index');
    })->name('home');

    Route::get('/blog', 'BlogController@index')->name('blog.index');

    Route::get('xeno-power', 'XenoController');

    Route::resource('encodings', 'EncodingsController');

    Route::resource('encoding.metas', 'EncodingMetasController');
    Route::resource('encoding.resources', 'EncodingResourcesController');

    //Route::get('/projects', 'ProjectController@index')->name('project.index');
    
    Route::resource('resources', 'ResourcesController');
    Route::resource('resource-types', 'ResourceTypesController');

    Route::get('/resource-type/{resource_type}/attributes/sort', 'ResourceTypeAttributesController@sortIndex')
        ->name('resource-type.attributes.sort-index');
    Route::put('/resource-type/{resource_type}/attributes/sort', 'ResourceTypeAttributesController@sort')
        ->name('resource-type.attributes.sort');

    Route::resource('resource-type.attributes', 'ResourceTypeAttributesController');

    Route::get('/resource-type/{resource_type}/resources/create', 'ResourceTypeResourcesController@create')
        ->name('resource-type.resources.create');

    Route::post('/resource-type/{resource_type}/resources', 'ResourceTypeResourcesController@store')
        ->name('resource-type.resources.store');

    Route::put('/resource-type/{resource_type}/resources/{resource}', 'ResourceTypeResourcesController@update')
        ->name('resource-type.resources.update');

    Route::put('/resource-type/{resource_type}/connections', 'ResourceTypeConnectionsController@update')
        ->name('resource-type.connections.update');

    Route::get('/resource-type/{resource_type}/activities', 'ResourceTypeActivitiesController@index')
        ->name('resource-type.activities.index');

    Route::resource('resource.connections', 'ResourceConnectionsController');
    Route::resource('resource.metas', 'ResourceMetasController');
    Route::resource('resource.media', 'ResourceMediaController');
    Route::resource('resource.temporalities', 'ResourceTemporalitiesController');
    Route::resource('resource.lineages', 'ResourceLineagesController');

    Route::get('activities', 'ActivityController@index')->name('activity.index');
});

Auth::routes();
