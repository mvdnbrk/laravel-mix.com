<?php

use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\DocumentationRedirectController;
use App\Http\Controllers\DocumentationRootController;
use App\Http\Controllers\ExtensionsController;
use App\Http\Controllers\HomepageController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('docs/master/{page}', fn (string $page) => redirect('docs/main/'.$page, Response::HTTP_MOVED_PERMANENTLY));

Route::middleware(['page-cache'])->group(function () {
    Route::get('/', [HomepageController::class, 'show'])->name('homepage');

    Route::get('extensions', [ExtensionsController::class, 'index'])->name('extensions.index');
    Route::get('extensions/{extension}', [ExtensionsController::class, 'show'])->name('extensions.show');

    Route::get('docs/{version}/{page}', [DocumentationController::class, 'show'])->name('documentation.show');
});

Route::get('docs', [DocumentationRootController::class, 'show'])->name('documentation.root');
Route::get('docs/{page}', [DocumentationRedirectController::class, 'show'])->name('documentation.redirect');
