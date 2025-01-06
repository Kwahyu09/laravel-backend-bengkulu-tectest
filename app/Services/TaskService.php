<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    // Mendapatkan semua task
    public function getAllTasks()
    {
        return Task::all();
    }

    // Mendapatkan task berdasarkan ID
    public function getTaskById($id)
    {
        return Task::findOrFail($id);
    }

    // Membuat task baru
    public function createTask(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Task::create($data);
        });
    }

    // Mengupdate task berdasarkan ID
    public function updateTask($id, array $data)
    {
        $task = Task::findOrFail($id);
        $task->update($data);

        return $task;
    }

    // Menghapus task berdasarkan ID
    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}
