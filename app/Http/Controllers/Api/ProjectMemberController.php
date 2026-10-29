<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectMemberController extends Controller
{
    public function index(Project $project): JsonResponse
    {
        Gate::authorize('view', $project);

        $members = $project->members()->get()->map(function ($member) {
            return [
                'user' => new UserResource($member),
                'role' => $member->pivot->role,
            ];
        });

        return response()->json(['members' => $members]);
    }

    public function store(Request $request, Project $project): JsonResponse
    {
        Gate::authorize('manageMembers', $project);

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'role' => ['required', 'in:admin,member,viewer'],
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        if ($project->members()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'User is already a member of this project'], 422);
        }

        $project->members()->attach($user->id, ['role' => $request->role]);

        return response()->json(['message' => 'Member added successfully'], 201);
    }

    public function destroy(Project $project, User $user): JsonResponse
    {
        Gate::authorize('manageMembers', $project);

        if ($project->owner_id === $user->id) {
            return response()->json(['message' => 'Cannot remove project owner'], 422);
        }

        $project->members()->detach($user->id);

        return response()->json(['message' => 'Member removed successfully']);
    }
}
