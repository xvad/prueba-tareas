<?php

namespace App\Task\Presentation\Http\Middleware;

use App\Task\Infrastructure\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class CheckTaskOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $taskId = $request->route('id');
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        if (!Gate::allows('manage-task', $task)) {
            return response()->json(['message' => 'No esta autorizado para realizar esta acción'], 403);
        }

        return $next($request);
    }
} 