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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'RegisterController@register');
Route::post('/login', 'LoginController@login');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', 'LoginController@logout');

    Route::get('/category', 'CategoryController@index');            // get all categories
    Route::post('/category', 'CategoryController@store');           // create new category
    Route::delete('/category/{id}', 'CategoryController@destroy');  // delete category

    Route::get('/resource', 'ResourceController@index');            // get all resources from category (?category={id})
    Route::post('/resource', 'ResourceController@store');           // create new resource
    Route::put('/resource/{id}', 'ResourceController@update');      // update resource
    Route::delete('/resource/{id}', 'ResourceController@destroy');  // delete resource

    Route::get('/tag', 'TagController@index');                      // get all user tags

    Route::get('/export', 'ResourceController@export');             // export user resources
    Route::post('/import', 'ResourceController@import');            // import user resources
});
