<?php

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_has_a_tasks()
    {
        $project = $this->create(Project::class);

        $this->create(Task::class, ['project_id' => $project]);

        $this->assertInstanceOf(Task::class, $project->tasks->first());
    }

    /** @test */
    public function it_adds_a_task()
    {
        $project = $this->create(Project::class);

        $project->addTask(['body' => $this->faker->sentence()]);

        $this->assertDatabaseCount('tasks', 1);
        $this->assertCount(1, $project->tasks);
    }

    /** @test */
    public function it_has_activities()
    {
        $project = $this->create(Project::class);

        $this->assertCount(1, $project->activities);
    }

    /** @test */
    public function it_can_invite_user()
    {
        $project = $this->create(Project::class);

        $user = $this->create(User::class);

        $project->invite($user);

        $this->assertEquals($project->members->first()->id, $user->id);
    }

    /** @test */
    public function it_fetches_accessible_projects_for_a_user()
    {
        $project = $this->create(Project::class);
        $user = $this->create(User::class);

        $project->invite($user);

        $this->assertTrue($project->accessibleProjects($user)->get()->contains($project));
        $this->assertCount(1, $project->accessibleProjects($user)->get());
        
        $anotherProject = $this->create(Project::class);
        $anotherProject->invite($this->create(User::class));      
        
        $this->assertFalse($project->accessibleProjects($user)->get()->contains($anotherProject));
        $this->assertCount(1, $project->accessibleProjects($user)->get());
    }
}
