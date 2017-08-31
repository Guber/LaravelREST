<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'auth.basic'], function () {
    Route::resource('tasks', 'TaskController');
    Route::resource('projects', 'ProjectController');
    Route::get('/projects/{id}/tasks', 'ProjectController@showtasks');
    Route::resource('users', 'UserController');
    Route::get('/users/{id}/tasks', 'UserController@showtasks');
});


Auth::routes();

Route::get('/home', 'HomeController@index');
