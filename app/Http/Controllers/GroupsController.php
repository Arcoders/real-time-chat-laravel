<?php

namespace App\Http\Controllers;

use App\Group;
use App\Notifications\ManageGroupsNotification;
use App\Traits\TriggerPusher;
use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class GroupsController extends Controller
{

    use UploadFiles;
    use TriggerPusher;

    protected $folder = '/images/avatars/';

    public function create(Request $request)
    {

        $request['id'] = $this->idsToArray($request['id']);

        $request->validate([

            'name' => 'required|unique:groups|min:4|max:15',

            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000',

            'id'  => 'required|array|min:1'
        ],
        [
            'id.required' => 'You must select at least one user'
        ]);

        $avatar = null;

        $user = Auth::user();

        if ($request->file('avatar')) {

            $avatar = $this->processImage($request->file('avatar'), $user->id, $this->folder);
        }

        Group::create([

            'name' => $request['name'],

            'user_id' => $user->id,

            'avatar' => $avatar

        ])->users()->sync($request['id']);

        $this->notifyUsers(user::find($request['id']), 'invited you to the ' . $request['name'] . ' group');

        return response()->json($request['name'] . " created successfully", 200);
    }

    public function my()
    {
        $groups = Group::where('user_id', Auth::user()->id)->withTrashed()->paginate(4);

        return response()->json($groups, 200);
    }

    public function delete($group_id)
    {
        $group = Group::myGroup($group_id);

        $group->delete();

        $this->notifyUsers($group->users, "$group->name group was archived");

        return response()->json("Group was deleted", 200);
    }

    public function restore($group_id)
    {
        $group = Group::myGroup($group_id);

        $group->restore();

        $this->notifyUsers($group->users, "$group->name group was restored");

        return response()->json("Group was restored", 200);
    }

    public function get($group_id)
    {
        return response()->json( ['group' => Group::myGroup($group_id), 'friends' => Auth::user()->friends()], 200);
    }

    public function friends()
    {
        return response(Auth::user()->friends(),200);
    }

    public function edit(Group $group, Request $request)
    {

        if ($request['deleteImage']) {

            $this->deleteImage($group->avatar);

            $group->avatar = null;

            $group->save();

            return response()->json('Avatar deleted successfully', 200);
        }

        $request['id'] = $this->idsToArray($request['id']);

        $request->validate([

            'name' => 'required|min:4|max:15|unique:groups,name,'.$group->id,

            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000',

            'id'  => 'required|array|min:1'
        ],
        [
            'id.required' => 'You must select at least one user'
        ]);

        if ($request->file('avatar')) {

            $this->deleteImage($group->avatar);

            $group->avatar = $this->processImage($request->file('avatar'), Auth::user()->id, $this->folder);

        }

        $group->name = $request['name'];

        $group->save();

        $group->users()->sync($request['id']);

        $old = $group->users->pluck('id')->toArray();

        $added = array_values(array_diff($request['id'], $old));

        $this->notifyUsers(user::find($added), "Invited you to the $group->name group");

        $deleted = array_values(array_diff($old, $request['id']));

        $this->notifyUsers(user::find($deleted), "Deleted you from the $group->name group");

        $fixed = $this->removeItems($old, $deleted);

        $this->notifyUsers(user::find($fixed), "Changes made to the $group->name group");

        return response()->json('Group edited successfully', 200);
    }

    protected function removeItems($users, $items)
    {

        foreach ($items as $i):

            $index = array_search($i, $users);
            if ( $index !== false ) unset( $users[$index]);

        endforeach;

        return $users;
    }

    protected function idsToArray($request)
    {
        $usersIds = $request ? explode(',', $request) : [];

        array_push($usersIds, Auth::user()->id);

        return $usersIds;
    }

    public function group($group_id)
    {
        return response()->json(Group::find($group_id), 200);
    }

    protected function notifyUsers($users, $message) {

        foreach ($users as $user):

            $this->triggerPusher("user$user->id", 'updateStatus', ['type' => 'group']);

            if ($user->id == Auth::user()->id) continue;

            Notification::send($user, new ManageGroupsNotification($message));

            $this->triggerPusher("notification$user->id", 'updateNotifications', []);

        endforeach;

    }


}