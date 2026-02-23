<?php

use App\Http\Controllers\Admin\ArticlesController;
use App\Http\Controllers\Admin\AuditsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ActiviteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuEmplacementController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\RessourceUtileController;
use App\Http\Controllers\Admin\ResultatController;
use App\Http\Controllers\Admin\RolesPermissionsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {

    Route::get('/symlink', function () {
        Artisan::call('storage:link');
    });

    Route::get('/login', [AuthController::class, 'login'])->name('app_login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordMail']);
    Route::get('/reset-password/{email}/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'passwordUpdate'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('app_logout');

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RolesPermissionsController::class, 'index'])->name('index');
        Route::get('/create', [RolesPermissionsController::class, 'create'])->name('create');
        Route::get('/{role}', [RolesPermissionsController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RolesPermissionsController::class, 'edit'])->name('edit');
        Route::get('/permissions/all', [RolesPermissionsController::class, 'indexPermissions'])->name('permissions.index');
    });
    // users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/create', [UsersController::class, 'create'])->name('create');
        Route::get('/{user}', [UsersController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit');
        Route::get('/{user}/password', [UsersController::class, 'updatePassword'])->name('password');
    });
    // categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    });
    // articles
    Route::prefix('articles')->name('articles.')->group(function () {
        Route::get('/', [ArticlesController::class, 'index'])->name('index');
        Route::get('/corbeille', [ArticlesController::class, 'corbeille'])->name('corbeille');
        Route::get('/archive', [ArticlesController::class, 'archive'])->name('archive');
        Route::get('/create', [ArticlesController::class, 'create'])->name('create');
        Route::get('/{article}', [ArticlesController::class, 'show'])->name('show');
        Route::get('/{article}/edit', [ArticlesController::class, 'edit'])->name('edit');
    });

    // videos
    Route::prefix('videos')->name('videos.')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('index');
        Route::get('/create', [VideoController::class, 'create'])->name('create');
        Route::get('/{video}', [VideoController::class, 'show'])->name('show');
        Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('edit');
    });

    // pages
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', [PagesController::class, 'index'])->name('index');
        Route::get('/create', [PagesController::class, 'create'])->name('create');
        Route::get('/{page}', [PagesController::class, 'show'])->name('show');
        Route::get('/{page}/edit', [PagesController::class, 'edit'])->name('edit');
    });

    // medias
    Route::prefix('medias')->name('medias.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::get('/create', [MediaController::class, 'create'])->name('create');
        Route::get('/{media}', [MediaController::class, 'show'])->name('show');
        Route::get('/{media}/edit', [MediaController::class, 'edit'])->name('edit');
    });

    // menus
    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::get('/{menu}', [MenuController::class, 'show'])->name('show');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
    });

    // menus emplacement
    Route::prefix('menu-emplacements')->name('menu-emplacements.')->group(function () {
        Route::get('/', [MenuEmplacementController::class, 'index'])->name('index');
        Route::get('/create', [MenuEmplacementController::class, 'create'])->name('create');
        Route::get('/{menuEmplacement}', [MenuEmplacementController::class, 'show'])->name('show');
        Route::get('/{menuEmplacement}/edit', [MenuEmplacementController::class, 'edit'])->name('edit');
    });

    // teams
    Route::prefix('teams')->name('teams.')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('index');
        Route::get('/create', [TeamController::class, 'create'])->name('create');
        Route::get('/{team}', [TeamController::class, 'show'])->name('show');
        Route::get('/{team}/edit', [TeamController::class, 'edit'])->name('edit');
    });

    // events
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
    });

        //composantes
    Route::prefix('elections')->name('elections.')->group(function () {
        Route::get('/', [ElectionController::class,'index'])->name('index');
        Route::get('/create', [ElectionController::class,'create'])->name('create');
        Route::get('/{election}', [ElectionController::class,'show'])->name('show');
        Route::get('/{election}/edit', [ElectionController::class,'edit'])->name('edit');
    });

    //composantes activites
    Route::prefix('resultats')->name('resultats.')->group(function () {
        Route::get('/', [ResultatController::class,'index'])->name('index');
        Route::get('/create', [ResultatController::class,'create'])->name('create');
        Route::get('/{resultat}', [ResultatController::class,'show'])->name('show');
        Route::get('/{resultat}/edit', [ResultatController::class,'edit'])->name('edit');
    });

    //activities
    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [ActiviteController::class, 'index'])->name('index');
        Route::get('/create', [ActiviteController::class, 'create'])->name('create');
        Route::get('/{activity}', [ActiviteController::class, 'show'])->name('show');
        Route::get('/{activity}/edit', [ActiviteController::class, 'edit'])->name('edit');
    });

    // Documentation
    Route::prefix('documentation')->name('documentation.')->group(function () {
        Route::get('/', [RessourceUtileController::class, 'index'])->name('index');
        Route::get('/create', [RessourceUtileController::class, 'create'])->name('create');
        Route::get('/{ressourcesUtile}', [RessourceUtileController::class, 'show'])->name('show');
        Route::get('/{ressourcesUtile}/edit', [RessourceUtileController::class, 'edit'])->name('edit');
        Route::get('/{docId}/download', [RessourceUtileController::class, 'edit'])->name('download');
    });

    // faqs
    Route::prefix('faqs')->name('faqs.')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/create', [FaqController::class, 'create'])->name('create');
        Route::get('/{faq}', [FaqController::class, 'show'])->name('show');
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('edit');
    });

    // faqs
    Route::prefix('newsletters')->name('newsletters.')->group(function () {
        Route::get('/followers', [NewsletterController::class, 'index'])->name('index');
        Route::get('/followers/create', [NewsletterController::class, 'createFollower'])->name('create-follower');
        Route::get('/campaigns', [NewsletterController::class, 'campaign'])->name('campaign');
        Route::get('/campaign/create', [NewsletterController::class, 'createCampaign'])->name('create-campaign');
        Route::get('/campaign/{campaign}/show', [NewsletterController::class, 'show'])->name('show');
        Route::get('/campaign/{campaign}/edit', [NewsletterController::class, 'edit'])->name('edit');
    });

    // settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/create', [SettingsController::class, 'create'])->name('create');
        Route::get('/{setting}', [SettingsController::class, 'show'])->name('show');
        Route::get('/{setting}/edit', [SettingsController::class, 'edit'])->name('edit');
    });

    // audits
    Route::prefix('audits')->name('audits.')->group(function () {
        Route::get('/', [AuditsController::class, 'index'])->name('index');
        Route::get('/{audit}', [AuditsController::class, 'show'])->name('show');
    });
});
