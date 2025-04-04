<?php

namespace App\Providers;

use App\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Auth\Infrastructure\Repositories\EloquentAuthRepository;
use App\Task\Domain\Repositories\TaskRepositoryInterface;
use App\Task\Infrastructure\Repositories\EloquentTaskRepository;
use App\User\Application\Repositories\UserRepositoryInterface;
use App\User\Infrastructure\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, EloquentAuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
