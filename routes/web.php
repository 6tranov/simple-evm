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

Route::get('/profile','UsersController@showProfile');

Route::get('/follows','FollowsController@followsIndex');
Route::get('/followers','FollowsController@followersIndex');

//Route::post('/follows','FollowsController@store');
Route::delete('/follows','FollowsController@delete');

Route::get('/users/search','UsersController@searchUsers');

Route::get('/users/{user}/profile','UsersController@showOthersProfile');

Route::get('/users/{user}/follows','FollowsController@othersFollowsIndex');
Route::get('/users/{user}/followers','FollowsController@othersFollowersIndex');