<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = $this->create(Task::class);

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_toggles_completed_value()
    {
        $task = $this->create(Task::class);

        $this->assertFalse($task->completed);
        $task->toggleCompleted();
        $this->assertTrue($task->fresh()->completed);
    }

    /** @test */
    public function it_has_activites()
    {
        $project = $this->create(Project::class);

        $this->assertCount(1, $project->activities);
    }
}
