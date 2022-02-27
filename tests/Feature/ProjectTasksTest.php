<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guests_cannot_create_tasks()
    {
        $this->post('projects/1/tasks')->assertRedirect('login');
    }

    /** @test */
    public function a_tast_requires_a_body()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->id()]);

        $route = route('projects.tasks.store', $project);

        $this->post($route)->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_project_can_has_tasks()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->id()]);

        $task = $this
            ->make(Task::class, ['owner_id' => auth()->id(), 'project_id' => $project])
            ->toArray();

        $route = route('projects.tasks.store',  $project);
        $this->post($route, $task);

        $this->assertDatabaseHas('tasks', $task);
        $this->assertCount(1, $project->tasks);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = $this->create(Project::class);

        $route = route('projects.tasks.store',  $project);
        $this->post($route)->assertStatus(403);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);

        $task = $this->create(Task::class, [
            'owner_id' => auth()->user(),
            'project_id' => $project
        ]);

        $route = route('projects.tasks.update', ['project' => $project, 'task' => $task]);
        $attributes = ['body' => 'body changed'];

        $this->patch($route, $attributes);
        $this->assertDatabaseHas('tasks', $attributes);

        $this->patch($route, ['completed' => '']);
        $this->assertTrue($task->fresh()->completed);

        $this->patch($route, ['completed' => '']);
        $this->assertFalse($task->fresh()->completed);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();

        $project = $this->create(Project::class);
        $task = $project->addTask(['body' => 'task body']);

        $route = route('projects.tasks.update', ['project' => $project, 'task' => $task]);

        $this->patch($route)->assertStatus(403);
    }
}
