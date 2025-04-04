<?php

namespace App\Providers;

use App\Task\Infrastructure\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('manage-task', function ($user, Task $task) {
            return $user->id === $task->user_id;
        });
    }
} 