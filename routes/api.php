<?php

use App\Http\Controllers\Api\ArticlesController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactMailController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\MenuEmplacementController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ParamController;
use App\Http\Controllers\Api\RessourceUtileController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('cena/v1/')->group(function () {
    Route::get('/documents/public/file/{fileName}/download', [DocumentController::class, 'publicDownloadLink'])->name('download.public');
    // auth

    // Liste des pages
    Route::group(['prefix' => 'pages'], function () {
        Route::get('/', [PageController::class, 'index']);
        Route::get('/{slug}', [PageController::class, 'show']);
    });

    // Paramètres du site

    Route::get('/site/parametres', [ParamController::class, 'index']);

    // Liste des articles
    Route::group(['prefix' => 'articles'], function () {
        Route::get('/', [ArticlesController::class, 'index']);
        Route::get('/archives', [ArticlesController::class, 'archive']);
        Route::get('/slider', [ArticlesController::class, 'sliderArticles']);
        Route::get('/{article}', [ArticlesController::class, 'show']);
        Route::get('/{slug}/show', [ArticlesController::class, 'showBySlug']);
    });
    // Newsletter
    Route::group(['prefix' => 'news-letter'], function () {
        Route::post('/', [NewsletterController::class, 'store']);
        Route::post('/unsubscribe', [NewsLetterController::class, 'unsubscribe']);
    });

    // contact mail
    Route::group(['prefix' => 'contact'], function () {
        Route::post('/', [ContactMailController::class, 'store']);
    });

    Route::group(['prefix' => 'teams'], function () {
        Route::get('/', [TeamController::class, 'index']);
    });

    // Ressources
    Route::group(['prefix' => 'documentation'], function () {
        Route::get('/avis-et-decisions', [RessourceUtileController::class, 'index']);
        Route::get('/documentation', [RessourceUtileController::class, 'documentation']);
        Route::get('/ressourcesByCategorie', [RessourceUtileController::class, 'ressourceByCategorie']);
    });

    // Catégorie
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index']);
    });

    // Liste des évènements
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', [EventController::class, 'index']);
    });

    // Liste des emplacements menus
    Route::get('/menus/emplacements', [MenuEmplacementController::class, 'index']);

    // Emplacement menu
    Route::get('/menus/{emplacementCode}/emplacement', [MenuEmplacementController::class, 'show']);

    // Liste des faqs
    Route::get('/faqs', [FaqController::class, 'index']);

});
