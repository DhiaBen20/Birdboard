<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Gate;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        Gate::authorize('store-task', $project);

        $attributes = request()->validate(['body' => 'required']);

        $project->addTask($attributes);

        return back();
    }

    public function update(Project $project, Task $task)
    {
        Gate::authorize('update-task', $project);

        if (request()->has('completed')) {
            $task->toggleCompleted();
        } else {
            $attributes = request()->validate([
                'body' => 'required',
            ]);

            $task->update($attributes);
        }

        return back();
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();
    }
}
