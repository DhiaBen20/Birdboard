<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Gate;

class ProjectInvitationController extends Controller
{
    public function store(Project $project)
    {
        Gate::allowIf(fn (User $user) => $project->owner->is($user));

        request()->validate(
            ['email' => 'required|exists:users,email'],
            ['email.exists' => 'the users you are inviting must have a valid Birdboard account.']
        );

        $user = User::where('email', request('email'))->first();

        $project->invite($user);

        return back();
    }
}
