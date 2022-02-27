<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function toggleCompleted()
    {
        $this->update(['completed' => !$this->completed]);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public static function booted()
    {
        static::created(function ($task) {
            $task->activities()->create(['description' => 'task_created']);
        });

        static::deleted(function ($task) {
            $task->activities()->create(['description' => 'task_deleted']);
        });

        static::updated(function ($task) {
            $task->activities()->create([
                'description' => $task->completed ? 'task_completed' : 'task_incompleted'
            ]);
        });
    }
}
