<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Auth\Domain\Repositories\UserRepositoryInterface;
use App\Auth\Infrastructure\Repositories\EloquentUserRepository;
use App\Auth\Application\Services\AuthService;
use Tymon\JWTAuth\JWT;
use App\Task\Infrastructure\Models\Task;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definir el Gate para verificar la propiedad de una tarea
        Gate::define('manage-task', function ($user, Task $task) {
            return $user->id === $task->user_id;
        });
    }

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService($app->make(JWT::class));
        });
    }
}
