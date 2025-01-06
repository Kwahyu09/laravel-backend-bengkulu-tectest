<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskShare extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'shared_with', 'permission'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }
}
