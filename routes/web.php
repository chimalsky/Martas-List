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

Route::get('/', function(Request $request) {
    return redirect()->route('project.index');
});

Route::prefix('dearchived')->name('dearchived.')->namespace('Dearchived')->group(function () {
    Route::get('/dearchived', 'BirdController@show')->name('bird.show');
});

Route::prefix('project')->name('project.')->namespace('Project')->group(function () {
    Route::get('/', 'IndexController')->name('index');
    Route::get('/about', 'AboutController')->name('about');
    Route::get('/coordinates', 'CoordinatesController')->name('coordinates');
    Route::get('/primary-sources', 'PrimarySourcesController')->name('primary-sources');
    Route::get('/poems', 'PoemsController@index')->name('poems.index');
    Route::get('/poems/{poem}', 'PoemsController@show')->name('poems.show');
    Route::post('/poems/get', 'PoemsController@index')->name('poems.indexAsync');

    Route::get('/poems/{poem}/affiliated', 'AffiliatedPoemsController')->name('affiliated.poems');
    Route::get('/poems/{poem}/commentary', 'PoemCommentaryController')->name('poems.commentary');

    Route::get('/partials/poems', function() {
        $poems = App\Resource::where('resource_type_id', 3)
            ->get()
            ->groupBy('queries_meta_value');

        return view('project.poems._list', ['poems' => $poems, 'query' => request()->query('query')]);
    });

    Route::get('/partials/birds', function() {
        $birds = App\Resource::where('resource_type_id', 2)
            ->get()
            ->groupBy('queries_meta_value');

        return view('project.birds._index', ['birds' => $birds]);
    });
    
    Route::get('/birds', 'BirdsController@index')->name('birds.index');
    Route::get('/birds/{bird}', 'BirdsController@show')->name('birds.show');
    Route::get('/birds/{bird}/poems', 'BirdPoemsController')->name('bird.poems');
    Route::get('/birds/{bird}/data', 'BirdsDataController')->name('birds.data');

    Route::get('/digital-objects', 'DigitalObjects\IndexController')->name('digital-objects.index');

    Route::get('/digital-object/birdring', 'DigitalObjects\BirdRingController')->name('digital-objects.birdring');
});

Route::group(['middleware' => 'auth'], function() {

    Route::get('/home', function() {
        return redirect()->route('resource-types.index');
    })->name('home');

    Route::get('/blog', 'BlogController@index')->name('blog.index');

    Route::get('xeno-power', 'XenoController');

    /*Route::resource('encodings', 'EncodingsController');

    Route::resource('encoding.metas', 'EncodingMetasController');
    Route::resource('encoding.resources', 'EncodingResourcesController');*/

    //Route::get('/projects', 'ProjectController@index')->name('project.index');

    /**
     *  Resource Category Routes
     */

    Route::get('/resource-type/{resource_type}/categories', 'ResourceCategoriesController@index')
        ->name('resource.categories.index');
    Route::post('/resource-type/{resource_type}/category', 'ResourceCategoriesController@store')
        ->name('resource.categories.store');
    Route::get('/resource-category/{resource_category}', 'ResourceCategoriesController@show')
        ->name('resource.category.show');
    Route::post('/resource-category/{resource_category}/resource', 'AttachResourceToCategoryController')
        ->name('resourceCategory.attach.resource');
    
    Route::resource('resources', 'ResourcesController');
    Route::resource('resource-types', 'ResourceTypesController');

    Route::get('/resource-type/{resource_type}/attributes/sort', 'ResourceTypeAttributesController@sortIndex')
        ->name('resource-type.attributes.sort-index');
    Route::put('/resource-type/{resource_type}/attributes/sort', 'ResourceTypeAttributesController@sort')
        ->name('resource-type.attributes.sort');

    Route::resource('resource-type.attributes', 'ResourceTypeAttributesController');

    Route::get('resource-type/{resource_type}/attribute/{attribute}/options/edit', 
        'ResourceTypeAttributeOptionsController@edit')
        ->name('resource-type.attribute.options.edit');

    Route::put('resource-type/{resource_type}/attribute/{attribute}/options', 
        'ResourceTypeAttributeOptionsController@update')
        ->name('resource-type.attribute.options.update');
    
    Route::delete('resource-type/{resource_type}/attribute/{attribute}/options', 
        'ResourceTypeAttributeOptionsController@destroy')
        ->name('resource-type.attribute.options.destroy');
    
    Route::post('resource-type/{resource_type}/attribute/{attribute}/options/sort', 
        'ResourceTypeAttributeOptionsController@sort')
        ->name('resource-type.attribute.options.sort');
    
    Route::post('/resource-attribute/{attribute}/options/sort', 
        'ResourceAttributeOptionsSortController')
        ->name('attribute.options.sort');

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

    Route::get('/resource-type/{resource_type}/spreadsheet-import', 'ResourceSpreadsheetImportController@show')
        ->name('resource-type.spreadsheetImport.show');
    Route::post('/resource-type/{resource_type}/spreadsheet-import', 'ResourceSpreadsheetImportController@store')
        ->name('resource-type.spreadsheetImport.store');

    /**
     *  Attribute Options
     */
    Route::post('/attribute/{attribute}/options/block', 'AttributeOptionsBlockStore')
        ->name('attribute.options.block.store');
        
    Route::resource('resource.connections', 'ResourceConnectionsController');
    
    Route::resource('resource.metas', 'ResourceMetasController');
    Route::resource('resource.media', 'ResourceMediaController');
    Route::resource('resource.temporalities', 'ResourceTemporalitiesController');
    Route::resource('resource.lineages', 'ResourceLineagesController');

    Route::get('activities', 'ActivityController@index')->name('activity.index');
});

Auth::routes(['register' => false]);
