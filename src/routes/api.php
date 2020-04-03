<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    ->namespace('API\\Auth')
    ->group( function ($router) {

        $router->prefix('admin')->group( function ($router) {
            $router->post('login', 'LoginController')->name('api.admin.login');
            $router->post('register', 'RegisterController@register')->name('api.admin.register');
            $router->post('refresh', 'RefreshTokenController')->name('api.admin.refresh');
            $router->post('logout', 'LogoutController@logout')->name('api.admin.logout');
            $router->get('me', 'MeController@me')->name('api.admin.me');
            $router->post('profile', 'ProfileController@save')->name('api.admin.profile');
            $router->post('reset-password', 'ResetLinkController@resetPassword')->name('api.admin.reset.password.email');
            $router->post('reset/password', 'ResetPasswordController@resetPassword')->name('api.admin.reset.password');
        });

    });

Route::prefix('v1')
    ->middleware('auth:api')
    ->namespace('API')
    ->group( function ($router) {

        $router->prefix('admin')->group( function ($router) {
            \SIGA\AutoRoute::resources("users","UserController","users");
            \SIGA\AutoRoute::resources("companies","CompanyController","companies");
            \SIGA\AutoRoute::resources("users","UserController","users");
            \SIGA\AutoRoute::resources("roles","RoleController","roles");
            \SIGA\AutoRoute::resources("permissions","PermissionController","permissions");
            \SIGA\AutoRoute::resources("menus","MenuController","menus");
        });

    });
