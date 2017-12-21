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

// Auth...
Auth::routes();

// Welcome
Route::get('/', function () { return view('welcome'); });

// Group routes
Route::group(['middleware' => ['auth']], function () {

    // Home...
    Route::get('/home', 'HomeController@index')->name('home');

    // Groups...
    Route::post('/new_group', 'GroupsController@newGroup');
    Route::get('/my_groups', 'GroupsController@myGroups');

});
