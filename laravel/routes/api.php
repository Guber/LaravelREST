<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'auth.basic'], function () {
    Route::resource('tasks', 'TaskController');
    Route::resource('projects', 'ProjectController');
    Route::get('/projects/{id}/tasks', 'ProjectController@showtasks');
    Route::resource('users', 'UserController');
    Route::get('/users/{id}/tasks', 'UserController@showtasks');
});
