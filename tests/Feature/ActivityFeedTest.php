<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function creating_a_project_records_activity()
    {
        $this->signIn();

        $this->post('projects', $this->make(Project::class)->toArray());

        $this->assertDatabaseCount('activities', 1);
        $this->assertInstanceOf(Project::class, Activity::first()->subject);
        $this->assertEquals('project_created', Activity::first()->description);
    }

    /** @test */
    public function updating_project_records_activity()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);

        $route = route('projects.update', $project);
        $attributes = $this->make(Project::class, ['owner_id' => auth()->user()])->toArray();

        $this->patch($route, $attributes);

        $this->assertDatabaseCount('activities', 2);
        $this->assertInstanceOf(Project::class, Activity::find(2)->subject);
        $this->assertEquals('project_updated', Activity::find(2)->description);
    }

    /** @test */
    public function creating_a_task_records_activity()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);

        $route = route('projects.tasks.store', $project);
        $attributes = $this->make(Task::class, [
            'owner_id' => auth()->user(),
            'project_id' => $project
        ])->toArray();

        $this->post($route, $attributes);

        $this->assertDatabaseCount('activities', 2);
        $this->assertInstanceOf(Task::class, Activity::find(2)->subject);
        $this->assertEquals('task_created', Activity::find(2)->description);
    }

    /** @test */
    public function completing_a_task_records_activity()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);
        $task = $project->addTask(['body' => 'task body']);

        $route = route('projects.tasks.update', ['project' => $project, 'task' => $task]);

        $this->patch($route, ['completed' => '']);

        $this->assertDatabaseCount('activities', 3);
        $this->assertInstanceOf(Task::class, Activity::find(3)->subject);
        $this->assertEquals('task_completed', Activity::find(3)->description);
    }

    /** @test */
    public function incompleting_a_task_records_activity()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);
        $task = $project->addTask(['body' => 'task body', 'completed' => true]);

        $route = route('projects.tasks.update', ['project' => $project, 'task' => $task]);

        $this->patch($route, ['completed' => '']);

        $this->assertDatabaseCount('activities', 3);
        $this->assertInstanceOf(Task::class, Activity::find(3)->subject);
        $this->assertEquals('task_incompleted', Activity::find(3)->description);
    }

    /** @test */
    public function deleting_a_task_records_activity()
    {
        $this->signIn();

        $project = $this->create(Project::class, ['owner_id' => auth()->user()]);

        $task = $project->addTask(['body' => 'task body']);

        $route = route('projects.tasks.destroy', ['project' => $project, 'task' => $task]);
        $this->delete($route);

        $this->assertDatabaseCount('activities', 3);
        $this->assertEquals('task_deleted', Activity::find(3)->description);
    }
}
