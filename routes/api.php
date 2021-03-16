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



/*
|--------------------------------------------------------------------------
| Authentication API Routes
|--------------------------------------------------------------------------
|
| These are the public API whose are accessed without token. Most probably use for Website.
|
*/



Route::group(['middleware' => 'api', 'namespace' => 'App\Http\Controllers', 'prefix' => 'auth'], function ($router) {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::get('/me', 'AuthController@me');
    Route::post('/refresh', 'AuthController@refresh');
});




/*
|--------------------------------------------------------------------------
| Private API Routes
|--------------------------------------------------------------------------
|
| These are the public API whose are accessed without token. Most probably use for Website.
|
*/


Route::group(['middleware' => ['jwt.auth'], 'namespace' => 'App\Http\Controllers', 'prefix' => 'auth'], function($router){
      // Products
      Route::get('/products/{page}/{itemsPerPage}', 'ProductController@getAll');
      Route::post('/productUpdate', 'ProductController@productUpdate');
      Route::apiResource('/products', 'ProductController');
});