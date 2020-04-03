<?php

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

Route::group(['prefix'=>'/admin'], function ($router){
    $router->get('/{vue_capture?}',"AdminController@index")
    ->where('vue_capture', '[\/\w\.\,\-]*')
        ->name('siga-admin-welcome');
});
