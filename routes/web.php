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

Route::get('/', 'WelcomeController@show');

Route::get('/extensions', 'ExtensionsController@index')->name('extensions.index');
Route::get('/extensions/{extension}', 'ExtensionsController@show')->name('extensions.show');

Route::get('/docs', 'DocumentationRootController@show');
Route::get('/docs/{page}', 'DocumentationRedirectController@show');
Route::get('/docs/{version}/{page}', 'DocumentationController@show');
