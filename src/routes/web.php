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

    $router->get('/welcome/user/listar', "API\\UserController@index")->name('siga-admin-welcome-user');
    $router->get('/welcome', "AdminController@index")->name('siga-admin-welcome');
    $router->get('/welcome/{id}', "AdminController@show")->name('siga-admin-show');

    $router->get('/{vue_capture?}', function (){
        return view('siga::layouts.admin');
    })
    ->where('vue_capture', '[\/\w\.\,\-]*')
    ->name('siga-admin-start');
});
