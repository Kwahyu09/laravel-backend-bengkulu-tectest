<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskShare;
use App\Models\User;

class TaskShareController extends Controller
{
    // Undang pengguna untuk berbagi task
    public function inviteUser(Request $request, $taskId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|in:view-only,edit',
        ]);

        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($request->user_id);

        // Cek apakah pengguna sudah memiliki akses
        $existingShare = TaskShare::where('task_id', $task->id)
                                  ->where('user_id', $user->id)
                                  ->first();

        if ($existingShare) {
            return response()->json(['message' => 'User already has access to this task'], 400);
        }

        // Membagikan task dengan izin yang diberikan
        TaskShare::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'permission' => $request->permission,
        ]);

        return response()->json(['message' => 'Task shared successfully'], 200);
    }

    // Melihat pengguna yang memiliki akses ke task
    public function showAccessList($taskId)
    {
        $task = Task::findOrFail($taskId);
        $shares = $task->shares()->with('user')->get();

        return response()->json($shares);
    }

    // Menghapus akses pengguna dari task
    public function removeAccess(Request $request, $taskId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $task = Task::findOrFail($taskId);

        // Menghapus akses pengguna
        TaskShare::where('task_id', $task->id)
                 ->where('user_id', $request->user_id)
                 ->delete();

        return response()->json(['message' => 'Access removed successfully'], 200);
    }
}
