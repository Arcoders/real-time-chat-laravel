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

    public function my()
    {
        $groups = Group::where('user_id', Auth::user()->id)->withTrashed()->paginate(3);

        return response()->json($groups, 200);
    }

    public function delete($group_id)
    {
        $group = Group::myGroup($group_id);

        $group->delete();

        foreach ($group->users as $user):

            $this->triggerPusher("user$user->id", 'updateStatus', ['type' => 'group']);

            if ($user->id == Auth::user()->id) continue;

            $this->notifyUsers($user, "$group->name group was archived");

        endforeach;

        return response()->json("Group was deleted", 200);
    }

    public function restore($group_id)
    {
        $group = Group::myGroup($group_id);

        $group->restore();

        foreach ($group->users as $user):

            $this->triggerPusher("user$user->id", 'updateStatus', ['type' => 'group']);

            if ($user->id == Auth::user()->id) continue;

            $this->notifyUsers($user, "$group->name group was restored");

        endforeach;

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

        return response()->json('Group edited successfully', 200);
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

    protected function notifyUsers(User $user, $message)
    {
        Notification::send($user, new ManageGroupsNotification($message));

        $this->triggerPusher("notification$user->id", 'updateNotifications', []);
    }

}