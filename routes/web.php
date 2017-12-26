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
    Route::delete('/delete_group/{group_id}', 'GroupsController@deleteGroup');
    Route::get('/get_group/{group_id}', 'GroupsController@getGroup');
    Route::post('/edit_group/{group_id}', 'GroupsController@editGroup');
    Route::get('/list_friends', 'GroupsController@listFriends');

    Route::get('/list_groups_chat', 'GroupsController@listChatsGroup');

    // Profile...
    Route::get('/get_profile/{profile_id}', 'ProfileController@getProfile');
    Route::get('/get_users', 'ProfileController@getUsers');
    Route::post('/edit_profile', 'ProfileController@editProfile');

    // Friendships
    Route::get('/check_relationship_status/{user_id}', 'FriendshipsController@check');
    Route::post('/add_friend/{user_id}', 'FriendshipsController@add_friend');
    Route::patch('/accept_friend/{user_id}', 'FriendshipsController@accept_friend');
    Route::delete('/reject_friendship/{user_id}', 'FriendshipsController@reject_friendship');


});
