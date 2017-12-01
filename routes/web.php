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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('threads', ThreadsController::class, ['except' => 'show']);
Route::resource('replies', RepliesController::class, ['only' => ['destroy', 'update']]);
Route::resource('threads/{channel}/{thread}/replies', RepliesController::class, ['only' => 'store']);
Route::resource('/replies/{reply}/favorites', FavoritesController::class, ['only' => ['store']]);

Route::get('profiles/{user}', ProfilesController::class.'@show')->name('profile');
Route::get('threads/{channel}/{thread}', ThreadsController::class.'@show');
Route::delete('threads/{channel}/{thread}', ThreadsController::class.'@destroy');
Route::get('threads/{channel}', ThreadsController::class.'@index');
