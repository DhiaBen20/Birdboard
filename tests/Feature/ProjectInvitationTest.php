<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectInvitationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_project_owner_can_invite_users()
    {
        $this->signIn();

        $project = $this->create(Project::class, [
            'owner_id' => auth()->user()
        ]);

        $userToInvite = $this->create(User::class);

        $route = route('invitations.store', $project);
        $this->post($route, ['email' => $userToInvite->email]);

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function invited_users_must_have_accounts()
    {
        $this->signIn();

        $project = $this->create(Project::class, [
            'owner_id' => auth()->user()
        ]);

        $route = route('invitations.store', $project);
        $this->post($route, ['email' => $this->faker->email()])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function only_project_owner_can_invite_users_to_thier_projects()
    {
        $project = $this->create(Project::class);

        $this->signIn();

        $project->invite(auth()->user());

        $route = route('invitations.store', $project);
        $this->post($route, ['email' => $this->faker->email()])
            ->assertStatus(403);
    }

    /** @test */
    public function invited_user_can_add_tasks()
    {
        $project = $this->create(Project::class);

        $this->signIn();

        $project->invite(auth()->user());

        $route = route('projects.tasks.store', $project);

        $task = ['body' => 'task body'];

        $this->assertDatabaseMissing('tasks', $task);
        $this->post($route, $task);
        $this->assertDatabaseHas('tasks', $task);
    }
}
