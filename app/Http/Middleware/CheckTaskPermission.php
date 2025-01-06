<?php

namespace App\Http\Middleware;

use App\Models\TaskShare;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTaskPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $taskId = $request->route('task_id');
        $userId = $request->user()->id;

        $taskShare = TaskShare::where('task_id', $taskId)
                              ->where('user_id', $userId)
                              ->where('permission', $permission)
                              ->first();

        if (!$taskShare) {
            return response()->json(['message' => 'You do not have permission to access this task'], 403);
        }

        return $next($request);
    }
}
