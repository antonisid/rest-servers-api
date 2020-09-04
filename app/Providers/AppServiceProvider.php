<?php

namespace App\Providers;

use App\Repositories\ServerRepository;
use App\Repositories\ServerRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\AuthenticationService;
use App\Services\AuthenticationServiceInterface;
use App\Services\ServerService;
use App\Services\ServerServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(ServerServiceInterface::class, ServerService::class);
        $this->app->bind(ServerRepositoryInterface::class, ServerRepository::class);

        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
