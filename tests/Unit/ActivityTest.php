<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_a_subject()
    {
        $this->create(Project::class);
        $this->assertInstanceOf(Project::class, Activity::first()->subject);

        $this->create(Task::class, ['project_id' => 1]);
        $this->assertInstanceOf(Task::class, Activity::find(2)->subject);
    }

    /** @test */
    public function it_fetches_activity_feed_for_a_specific_project()
    {
        $project = $this->create(Project::class);
        $project->addTask(['body' => $this->faker->sentence()]);

        $this->create(Project::class);
        $this->create(Task::class);

        $this->assertDatabaseCount('activities', 5);
        $this->assertCount(2, Activity::feed($project->id)->get());
    }

    /** @test */
    public function it_records_chagnes_when_updating_project()
    {
        $project = $this->create(Project::class);

        $expected = [
            'after' => ['title' => $project->title],
            'before' => ['title' => 'changed']
        ];

        $project->update(['title' => 'changed']);
        $this->assertEquals($expected, Activity::find(2)->changes);
    }
}
