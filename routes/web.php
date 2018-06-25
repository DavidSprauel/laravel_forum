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
Route::resource('replies', RepliesController::class, [
    'only' => ['destroy', 'update']
]);
Route::resource('threads/{channel}/{thread}/replies', RepliesController::class, [
    'only' => ['store', 'index']
]);
Route::resource('/replies/{reply}/favorites', FavoritesController::class, [
    'only' => ['store']
]);

Route::get('/register/confirm', 'Api\RegisterConfirmationController@index')->name('register.confirm');
Route::get('profiles/{user}', ProfilesController::class.'@show')->name('profile');
Route::get('profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('threads/{channel}/{thread}', ThreadsController::class.'@show');
Route::delete('threads/{channel}/{thread}', ThreadsController::class.'@destroy');
Route::get('threads/{channel}', ThreadsController::class.'@index');

Route::post('threads/{channel}/{thread}/subscriptions', ThreadSubscriptionController::class.'@store');
Route::delete('threads/{channel}/{thread}/subscriptions', ThreadSubscriptionController::class.'@destroy');

Route::delete('/replies/{reply}/favorites', FavoritesController::class.'@destroy');


Route::resource('api/users', 'Api\UsersController');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

