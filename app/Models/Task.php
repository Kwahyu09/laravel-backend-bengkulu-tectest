<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'deadline', 'status', 'labels', 'created_by'];

    protected $casts = [
        'labels' => 'array',
        'deadline' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shares()
    {
        return $this->hasMany(TaskShare::class, 'task_id');
    }
}
