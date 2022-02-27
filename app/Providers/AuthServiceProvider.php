<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(
            'manage-project',
            fn (User $user, Project $project) => $project->owner->is($user) || $project->members->contains($user)
        );

        Gate::define(
            'store-task',
            fn (User $user, Project $project) => $project->owner->is($user) || $project->members->contains($user)
        );

        Gate::define(
            'update-task',
            fn (User $user, Project $project) => $project->owner->is($user) || $project->members->contains($user)
        );
    }
}
