<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guests_cannot_create_projects()
    {
        $this->get('projects/create')->assertRedirect('login');
        $this->post('projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_projects()
    {
        $this->get('projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_single_project()
    {
        $this->get(route('projects.show', 1))->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_projects()
    {
        $this->signIn();

        $data = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph()
        ];

        $this->post('/projects', $data)->assertRedirect('projects');

        $this->assertDatabaseHas('projects', $data);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);

        $this->delete(route('projects.destroy', $project));

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $this->post('projects')->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $this->post('projects')->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $user = $this->signIn();

        $project = $this->create(Project::class,  ['owner_id' => $user->id]);

        $this->get(route('projects.show', $project))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Projects/Show')
                    ->has(
                        'project',
                        fn (Assert $page) => $page
                            ->where('title', $project->title)
                            ->where('description', $project->description)
                            ->etc()
                    )
            );
    }

    /** @test */
    public function authenticated_users_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = $this->create(Project::class);

        $this->get(route('projects.show', $project))->assertStatus(403);
    }

    /** @test */
    public function a_user_can_update_project()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);

        $route = route('projects.update', $project);
        $attributes = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
        ];

        $this->patch($route, $attributes);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_add_notes_to_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);

        $route = route('projects.update', $project);
        $attributes = [
            'notes' => $this->faker->sentence()
        ];

        $this->patch($route, $attributes);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function users_can_see_the_projects_invited_to()
    {
        $project = $this->create(Project::class);

        $this->signIn();

        $this->get(route('projects.index'))->assertInertia(
            fn (Assert $page) => $page->has('projects', 0)
        );

        $project->invite(auth()->user());

        $this->get(route('projects.index'))->assertInertia(
            fn (Assert $page) => $page
                ->has('projects', 1)
                ->where('projects', fn ($projects) => $projects->first()['id'] === $project->id)
        );
    }
}
