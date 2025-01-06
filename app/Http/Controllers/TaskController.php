<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Menampilkan semua task
    public function index()
    {
        return response()->json($this->taskService->getAllTasks());
    }

    // Menampilkan task berdasarkan ID
    public function show($id)
    {
        return response()->json($this->taskService->getTaskById($id));
    }

    // Membuat task baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',  // Deadline wajib diisi dan harus berupa tanggal yang valid
            'status' => ['required', Rule::in(['pending', 'in_progress', 'complete'])],
            'labels' => 'nullable|array',
            'created_by' => 'required|exists:users,id',
        ]);

        return response()->json($this->taskService->createTask($validated));
    }

    //mengubah data task
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',  // Deadline wajib diisi dan harus berupa tanggal yang valid
            'status' => ['required', Rule::in(['pending', 'in_progress', 'complete'])],
            'labels' => 'nullable|array',
        ]);

        return response()->json($this->taskService->updateTask($id, $validated));
    }

    // Menghapus task berdasarkan ID
    public function destroy($id)
    {
        $this->taskService->deleteTask($id);

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
