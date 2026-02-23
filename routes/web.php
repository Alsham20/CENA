<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    return redirect()->route('dashboard');
});
Route::get('/symlink', function () {
    Artisan::call('storage:link');
});

Route::get('/storage-link', function(){
    $targetFolder = storage_path('app/public');
    $linkFolder = public_path('storage');
    symlink($targetFolder, $linkFolder);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/api/public/livewire/update', $handle);
});
