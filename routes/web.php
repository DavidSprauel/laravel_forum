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
Route::get('threads/{channel}/{thread}', ThreadsController::class.'@show');
Route::get('threads/{channel}', ThreadsController::class.'@index');

Route::resource('threads/{channel}/{thread}/replies', RepliesController::class);
