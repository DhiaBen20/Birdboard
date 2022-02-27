<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function addTask(array $data)
    {
        $data['owner_id'] = $this->owner_id;
        return $this->tasks()->create($data);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_invites');
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }

    public function scopeAccessibleProjects($query, $user)
    {
        // $query->where('owner_id', $user->id)
        //     ->orWhereExists(
        //         fn ($query) => $query
        //             ->from('project_invites')
        //             ->where('user_id', $user->id)
        //             ->whereColumn('project_id', 'projects.id')
        //     );

        $query->where('owner_id', $user->id)
            ->orWhereHas(
                'members',
                fn ($query) => $query
                    ->where('user_id', $user->id)
            );
    }

    public static function booted()
    {
        static::created(function ($project) {
            $project->activities()->create(['description' => 'project_created']);
        });

        static::updated(function ($project) {
            $project->activities()->create([
                'description' => 'project_updated',
                'changes' => [
                    'after' => array_diff($project->getOriginal(), $project->getAttributes()),
                    'before' => $project->getChanges()
                ]
            ]);
        });
    }
}
