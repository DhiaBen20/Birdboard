<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn() {
        $user = User::factory()->create();

        $this->actingAs($user);

        return $user;
    }

    protected function factory($class, $count = null) {
        return $class::factory($count);
    }

    public function make($class, array $overrides = null, int $count = null)
    {
        return $this->factory($class, $count)->make($overrides);
    }

    public function create($class, array $overrides = null, int $count = null)
    {
        return $this->factory($class, $count)->create($overrides);
    }
}
