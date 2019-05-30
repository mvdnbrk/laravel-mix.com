<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ExtensionsController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\DocumentationRootController;
use App\Http\Controllers\DocumentationRedirectController;

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

Route::middleware(['page-cache'])->group(function () {
    Route::get('/', [HomepageController::class, 'show'])->name('homepage');

    Route::get('extensions', [ExtensionsController::class, 'index'])->name('extensions.index');
    Route::get('extensions/{extension}', [ExtensionsController::class, 'show'])->name('extensions.show');

    Route::get('docs/{version}/{page}', [DocumentationController::class, 'show'])->name('documentation.show');
});

Route::get('docs', [DocumentationRootController::class, 'show'])->name('documentation.root');
Route::get('docs/{page}', [DocumentationRedirectController::class, 'show'])->name('documentation.redirect');
