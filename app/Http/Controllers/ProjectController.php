<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Gate;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::accessibleProjects(auth()->user())->latest()->get();

        return Inertia::render('Projects/Index', [
            'projects' => $projects->map(fn ($project) => [
                'title' => $project->title,
                'description' => $project->description,
                'id' => $project->id,
            ])
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Auth::user()->projects()->create($attributes);

        return redirect('projects');
    }

    public function show(Project $project)
    {
        Gate::authorize('manage-project', $project);

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'tasks' => $project->tasks
        ]);
    }

    public function update(Project $project)
    {
        Gate::authorize('manage-project', $project);

        if (request()->missing('notes')) {
            $attributes = request()->validate([
                'title' => 'required',
                'description' => 'required',
            ]);
        } else {
            $attributes = request()->validate([
                'notes' => 'required',
            ]);
        }

        $project->update($attributes);

        return back();
    }

    public function destroy(Project $project)
    {
        Gate::authorize('manage-project', $project);

        $project->delete();
    }
}
