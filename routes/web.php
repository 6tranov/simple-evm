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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/','HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/projects','ProjectsController@index');
Route::get('/projects/create','ProjectsController@create');
Route::get('/projects/{project}/edit','ProjectsController@edit');
Route::get('/projects/{project}/task-orders/edit','TasksController@editOrders');
Route::get('/projects/{project}','ProjectsController@show');
Route::post('/projects','ProjectsController@store');
Route::put('/projects/{project}','ProjectsController@update');
Route::delete('/projects/{project}','ProjectsController@delete');

Route::get('/tasks/{task}','TasksController@edit');
Route::put('/tasks/{task}','TasksController@update');
Route::put('/projects/{project}/task-orders','TasksController@updateOrders');