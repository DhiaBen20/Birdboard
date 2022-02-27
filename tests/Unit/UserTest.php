<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_project()
    {
        $user = User::factory()->create();

        $this->create(Project::class, ['owner_id' => $user]);

        $this->assertInstanceOf(Project::class, $user->projects->first());
    }
}
