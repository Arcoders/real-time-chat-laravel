<?php

namespace App\Http\Controllers;

use App\Group;
use App\Traits\TriggerPusher;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{

    use UploadFiles;
    use TriggerPusher;

    protected $folder = '/images/avatars/';

    public function newGroup(Request $request)
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

        $avatar_name = null;
        $user = Auth::user();

        if ($request->file('avatar')) {

            $avatar_name = $this->processImage($request->file('avatar'), $user->id, $this->folder);
        }

        $group = Group::create([
            'name' => $request['name'],
            'user_id' => $user->id,
            'avatar' => $avatar_name
        ]);

        $group->users()->sync($request['id']);

        return response()->json("$group->name created successfully", 200);
    }

    public function myGroups()
    {
        $groups = Group::where('user_id', Auth::user()->id)->withTrashed()->paginate(4);

        return response()->json($groups, 200);
    }

    public function deleteGroup($group_id)
    {
        $group = Group::myGroup($group_id);

        $users = $group->users;

        $group->delete();

        foreach ($users as $user):

            $this->triggerPusher("user$user->id", 'updateStatus', ['update' => true]);

        endforeach;

        return response()->json("Group was deleted", 200);
    }

    public function restoreGroup($group_id)
    {
        $group = Group::myGroup($group_id);

        $users = $group->users;

        $group->restore();

        foreach ($users as $user):

            $this->triggerPusher("user$user->id", 'updateStatus', ['update' => true]);

        endforeach;

        return response()->json("Group was restored", 200);
    }

    public function getGroup($group_id)
    {
        $group = Group::myGroup($group_id);

        return response()->json($group,200);
    }

    public function listFriends()
    {
        return response(Auth::user()->friends(),200);
    }

    public function editGroup($group_id, Request $request)
    {
        $user = Auth::user();

        $group = Group::find($group_id);

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

            $group->avatar = $this->processImage($request->file('avatar'), $user->id, $this->folder);

        }

        $group->name = $request['name'];

        $group->save();

        $group->users()->sync($request['id']);

        return response()->json('Group edited successfully', 200);
    }

    protected function idsToArray($request)
    {
        $usersIds = $request ? explode(',', $request) : [];

        array_push($usersIds, Auth::user()->id);

        return $usersIds;
    }

    public function getGroupForChat($group_id)
    {
        return response()->json(Group::find($group_id), 200);
    }

}