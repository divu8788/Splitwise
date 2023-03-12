<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
class GroupController extends Controller
{
    public function store(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $group->save();

        $group->users()->attach($request->user_id);

        return response()->json([
            'message' => 'Group created successfully',
            'group' => $group
        ], 201);
    }

    public function addUser(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);
        $group->users()->attach($request->user_id);

        return response()->json([
            'message' => 'User added to group successfully'
        ]);
    }
}
