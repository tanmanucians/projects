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

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function () {
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
    Route::resource('/flashcard', 'FlashcardsController');
    Route::resource('/games' ,'GameController');

});

Route::prefix('games')->group(function () {
    Route::get('', 'GameController@index');
    Route::get('count_time', 'GameController@countTime');
    Route::get('result', 'GameController@result');
    Route::post('check', 'GameController@checkAnswer');
    Route::get('{id}', 'GameController@show');
    Route::get('{id}/flashcard', 'GameController@showFlashcard');
    Route::get('get_flashcard/{id}', 'GameController@getFlashcard');
    Route::post('submit_score', 'GameController@submitScore');
});

