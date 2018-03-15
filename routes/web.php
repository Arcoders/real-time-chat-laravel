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

Auth::routes();

Route::get('/', function () { return view('welcome'); });


Route::group(['middleware' => ['auth']], function () {

    // -----------------------------------------------------------------

    Route::get('/home', 'HomeController@index')->name('home');

    // -----------------------------------------------------------------

    Route::prefix('groups')->group(function () {

        Route::get('/my', 'GroupsController@my');
        Route::delete('/delete/{group_id}', 'GroupsController@delete');
        Route::delete('/restore/{group_id}', 'GroupsController@restore');

        Route::post('/create', 'GroupsController@create');
        Route::get('/friends', 'GroupsController@friends');


        Route::get('/get/{group_id}', 'GroupsController@get');
        Route::post('/edit/{group_id}', 'GroupsController@edit');
        
    });

    // -----------------------------------------------------------------

    Route::prefix('access-box')->group(function () {

        Route::get('/group_chat/{group_id}', 'GroupsController@group')->middleware('groupMember');
        Route::get('/friend_chat/{friend_id}', 'FriendshipsController@friend')->middleware('isFriend');

    });

    // -----------------------------------------------------------------

    Route::prefix('messages')->group(function () {

        Route::Post('/send', 'MessagesController@send');
        Route::get('/latest/{chat_id}/{room_name}', 'MessagesController@latest');
        Route::get('/typing/{chat_id}/{room_name}', 'MessagesController@typing');

    });

    // -----------------------------------------------------------------

    Route::prefix('profile')->group(function () {

        Route::get('/user/{user}', 'ProfileController@user');
        Route::get('/users', 'ProfileController@users');
        Route::post('/edit', 'ProfileController@edit');

    });

    // -----------------------------------------------------------------

    Route::prefix('friendship')->group(function () {

        Route::get('/check/{user_id}', 'FriendshipsController@check');
        Route::post('/add/{user_id}', 'FriendshipsController@add');
        Route::patch('/accept/{user_id}', 'FriendshipsController@accept');
        Route::delete('/reject/{user_id}', 'FriendshipsController@reject');

    });

    // -----------------------------------------------------------------

    Route::prefix('online')->group(function () {

        Route::get('/connected/{chat_id}/{room_name}', 'OnlineController@connected');
        Route::get('/disconnect/{chat_id}/{room_name}', 'OnlineController@disconnect');

    });

    // -----------------------------------------------------------------

    Route::prefix('notifications')->group(function () {

        Route::get('/count', 'NotificationsController@count');
        Route::get('/show', 'NotificationsController@show');
        Route::get('/mark_as_read', 'NotificationsController@markAsRead');

    });

    // -----------------------------------------------------------------

    Route::prefix('list')->group(function () {

        Route::get('/chats', 'ChatsController@chats');

    });

    // -----------------------------------------------------------------

});
