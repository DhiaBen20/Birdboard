<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'changes' => 'array'
    ];

    public function scopeFeed($query, $project_id)
    {
        $query->where(
            fn ($query) => $query
                ->where('subject_type', Project::class)
                ->where('subject_id', $project_id)
        );

        $query->orWhere(fn ($query) => $query
            ->where('subject_type', Task::class)
            ->whereExists(
                fn ($query) => $query
                    ->from('tasks')
                    ->where('project_id', $project_id)
                    ->whereColumn('id', 'activities.subject_id')
            ));
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
