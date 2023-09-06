<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Project::factory(6)->create(['owner_id' => $user]);
        Task::factory(3)->create(['owner_id' => 1, 'project_id' => 1]);
    }
}
