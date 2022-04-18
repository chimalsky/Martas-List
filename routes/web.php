<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttachResourceToCategoryController;
use App\Http\Controllers\AttributeOptionsBlockStore;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Dearchived;
use App\Http\Controllers\Project;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResourceAttributeOptionsSortController;
use App\Http\Controllers\ResourceCategoriesController;
use App\Http\Controllers\ResourceConnectionsController;
use App\Http\Controllers\ResourceLineagesController;
use App\Http\Controllers\ResourceMediaController;
use App\Http\Controllers\ResourceMetasController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\ResourceSpreadsheetImportController;
use App\Http\Controllers\ResourceTemporalitiesController;
use App\Http\Controllers\ResourceTypeActivitiesController;
use App\Http\Controllers\ResourceTypeAttributeOptionsController;
use App\Http\Controllers\ResourceTypeAttributesController;
use App\Http\Controllers\ResourceTypeConnectionsController;
use App\Http\Controllers\ResourceTypeResourcesController;
use App\Http\Controllers\ResourceTypesController;
use App\Http\Controllers\XenoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function (Request $request) {
    return redirect()->route('project.index');
});

Route::prefix('dearchived')->name('dearchived.')->group(function () {
    Route::get('/dearchived', [Dearchived\BirdController::class, 'show'])->name('bird.show');
});

Route::prefix('project')->name('project.')->group(function () {
    Route::get('/', Project\IndexController::class)->name('index');
    Route::get('/about', [Project\AboutController::class, 'index'])->name('about');
    Route::get('/about-overview', [Project\AboutController::class, 'overview'])->name('about-overview');
    Route::get('/about-navigation', [Project\AboutController::class, 'navigation'])->name('about-navigation');
    Route::get('/about-documentation', [Project\AboutController::class, 'documentation'])->name('about-documentation');

    Route::get('/coordinates', Project\CoordinatesController::class)->name('coordinates');
    Route::get('/primary-sources', Project\PrimarySourcesController::class)->name('primary-sources');
    Route::get('/poems', [Project\PoemsController::class, 'index'])->name('poems.index');
    Route::get('/poems/fetch', [Project\PoemsController::class, 'indexFetch'])->name('poems.index-fetch');
    Route::get('/poems/{poem}', [Project\PoemsController::class, 'show'])->name('poems.show');
    Route::post('/poems/get', [Project\PoemsController::class, 'index'])->name('poems.indexAsync');

    Route::get('/poems/{poem}/affiliated', Project\AffiliatedPoemsController::class)->name('affiliated.poems');
    Route::get('/poems/{poem}/commentary', Project\PoemCommentaryController::class)->name('poems.commentary');

    Route::get('/partials/poems', function () {
        $poems = App\Resource::where('resource_type_id', 3)
            ->get()
            ->groupBy('queries_meta_value');

        return view('project.poems._list', ['poems' => $poems, 'query' => request()->query('query')]);
    });

    Route::get('/partials/birds', function () {
        $birds = App\Resource::where('resource_type_id', 2)
            ->get()
            ->groupBy('queries_meta_value');

        return view('project.birds._index', ['birds' => $birds]);
    });

    Route::get('/birds', [Project\BirdsController::class, 'index'])->name('birds.index');
    Route::get('/birds/fetch', [Project\BirdsController::class, 'indexFetch'])->name('birds.index-fetch');
    Route::get('/birds/{bird}', [Project\BirdsController::class, 'show'])->name('birds.show');
    Route::get('/birds/{bird}/poems', Project\BirdPoemsController::class)->name('bird.poems');
    Route::get('/birds/{bird}/data', Project\BirdsDataController::class)->name('birds.data');

    //Route::get('/digital-objects', 'DigitalObjects\IndexController')->name('digital-objects.index');
    Route::get('/digital-objects/timeline', Project\DigitalObjects\TimelineController::class)->name('digital-objects.timeline');
    Route::get('/digital-objects/map', Project\DigitalObjects\MapController::class)->name('digital-objects.map');
    Route::get('/digital-object/birdring', Project\DigitalObjects\BirdRingController::class)->name('digital-objects.birdring');
    Route::get('/digital-object/birdring/fetch', Project\DigitalObjects\BirdRingFetchController::class)->name('digital-objects.birdring.fetch');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return redirect()->route('resource-types.index');
    })->name('home');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

    Route::get('xeno-power', XenoController::class);

    /*Route::resource('encodings', 'EncodingsController');

    Route::resource('encoding.metas', 'EncodingMetasController');
    Route::resource('encoding.resources', 'EncodingResourcesController');*/

    //Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');

    /**
     *  Resource Category Routes
     */
    Route::get('/resource-type/{resource_type}/categories', [ResourceCategoriesController::class, 'index'])
        ->name('resource.categories.index');
    Route::post('/resource-type/{resource_type}/category', [ResourceCategoriesController::class, 'store'])
        ->name('resource.categories.store');
    Route::get('/resource-category/{resource_category}', [ResourceCategoriesController::class, 'show'])
        ->name('resource.category.show');
    Route::post('/resource-category/{resource_category}/resource', AttachResourceToCategoryController::class)
        ->name('resourceCategory.attach.resource');

    Route::resource('resources', ResourcesController::class);
    Route::resource('resource-types', ResourceTypesController::class);

    Route::get('/resource-type/{resource_type}/attributes/sort', [ResourceTypeAttributesController::class, 'sortIndex'])
        ->name('resource-type.attributes.sort-index');
    Route::put('/resource-type/{resource_type}/attributes/sort', [ResourceTypeAttributesController::class, 'sort'])
        ->name('resource-type.attributes.sort');

    Route::resource('resource-type.attributes', ResourceTypeAttributesController::class);

    Route::get('resource-type/{resource_type}/attribute/{attribute}/options/edit',
        [ResourceTypeAttributeOptionsController::class, 'edit'])
        ->name('resource-type.attribute.options.edit');

    Route::put('resource-type/{resource_type}/attribute/{attribute}/options',
        [ResourceTypeAttributeOptionsController::class, 'update'])
        ->name('resource-type.attribute.options.update');

    Route::delete('resource-type/{resource_type}/attribute/{attribute}/options',
        [ResourceTypeAttributeOptionsController::class, 'destroy'])
        ->name('resource-type.attribute.options.destroy');

    Route::post('resource-type/{resource_type}/attribute/{attribute}/options/sort',
        [ResourceTypeAttributeOptionsController::class, 'sort'])
        ->name('resource-type.attribute.options.sort');

    Route::post('/resource-attribute/{attribute}/options/sort',
        ResourceAttributeOptionsSortController::class)
        ->name('attribute.options.sort');

    Route::get('/resource-type/{resource_type}/resources/create', [ResourceTypeResourcesController::class, 'create'])
        ->name('resource-type.resources.create');

    Route::post('/resource-type/{resource_type}/resources', [ResourceTypeResourcesController::class, 'store'])
        ->name('resource-type.resources.store');

    Route::put('/resource-type/{resource_type}/resources/{resource}', [ResourceTypeResourcesController::class, 'update'])
        ->name('resource-type.resources.update');

    Route::put('/resource-type/{resource_type}/connections', [ResourceTypeConnectionsController::class, 'update'])
        ->name('resource-type.connections.update');

    Route::get('/resource-type/{resource_type}/activities', [ResourceTypeActivitiesController::class, 'index'])
        ->name('resource-type.activities.index');

    Route::get('/resource-type/{resource_type}/spreadsheet-import', [ResourceSpreadsheetImportController::class, 'show'])
        ->name('resource-type.spreadsheetImport.show');
    Route::post('/resource-type/{resource_type}/spreadsheet-import', [ResourceSpreadsheetImportController::class, 'store'])
        ->name('resource-type.spreadsheetImport.store');

    /**
     *  Attribute Options
     */
    Route::post('/attribute/{attribute}/options/block', AttributeOptionsBlockStore::class)
        ->name('attribute.options.block.store');

    Route::resource('resource.connections', ResourceConnectionsController::class);

    Route::resource('resource.metas', ResourceMetasController::class);
    Route::resource('resource.media', ResourceMediaController::class);
    Route::resource('resource.temporalities', ResourceTemporalitiesController::class);
    Route::resource('resource.lineages', ResourceLineagesController::class);

    Route::get('activities', [ActivityController::class, 'index'])->name('activity.index');
});

Auth::routes(['register' => false]);
