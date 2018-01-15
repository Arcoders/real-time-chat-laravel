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
use App\User;


Auth::routes();

// Welcome
Route::get('/', function () { return view('welcome'); });

// Group routes
Route::group(['middleware' => ['auth']], function () {

    // Home...
    Route::get('/home', 'HomeController@index')->name('home');

    // User..
    Route::get('/get_user',  function () { return Auth::user(); });

    // Groups...
    Route::post('/new_group', 'GroupsController@newGroup'); // Add new group
    Route::get('/my_groups', 'GroupsController@myGroups'); // list my groups
    Route::delete('/delete_group/{group_id}', 'GroupsController@deleteGroup'); // delete selected group
    Route::get('/get_group/{group_id}', 'GroupsController@getGroup'); // get determinate group with users
    Route::get('/get_group_chat/{group_id}', 'GroupsController@getGroupForChat')->middleware('groupMember'); // get determinate just group
    Route::post('/edit_group/{group_id}', 'GroupsController@editGroup'); // edit group
    Route::get('/list_friends', 'GroupsController@listFriends'); // list all friends

    // Profile...
    Route::get('/get_profile/{profile_id}', 'ProfileController@getProfile'); // get determinate profile
    Route::get('/get_users', 'ProfileController@getUsers'); // get all users
    Route::post('/edit_profile', 'ProfileController@editProfile'); // edit my profile

    // Friendships...
    Route::get('/check_relationship_status/{user_id}', 'FriendshipsController@check'); // check relation ship status
    Route::post('/add_friend/{user_id}', 'FriendshipsController@addFriend'); // send friend request
    Route::patch('/accept_friend/{user_id}', 'FriendshipsController@acceptFriend'); // accept friend
    Route::delete('/reject_friendship/{user_id}', 'FriendshipsController@rejectFriendship'); // reject request

    // Chats list...
    Route::get('/chats_list', 'ChatsController@chatsList');

    // Send message
    Route::Post('/send_message', 'MessagesController@sendMessage');
    Route::get('/get_latest_group/{group_id}', 'MessagesController@lastMessagesGroup');
    Route::get('/user_typing/{group_id}', 'MessagesController@usersTyping');

    // Online users in group
    Route::get('/get_online_group_users/{group_id}', 'OnlineInGroupsController@onlineGroupUsers');
    Route::get('/disconnect_user/{group_id}', 'OnlineInGroupsController@disconnectUser');

    // Get friend info for chat
    Route::get('/get_friend_chat/{friend_id}', 'FriendshipsController@getFriendForChat');

});
