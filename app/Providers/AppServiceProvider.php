<?php

namespace App\Providers;

use App\Repositories\FunclocRepository;
use App\Repositories\Impl\FunclocRepositoryImpl;
use App\Repositories\Impl\MotorRepositoryImpl;
use App\Repositories\Impl\UserRepositoryImpl;
use App\Repositories\MotorRepository;
use App\Repositories\UserRepository;
use App\Services\FunclocService;
use App\Services\Impl\FunclocServiceImpl;
use App\Services\Impl\MotorServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\MotorService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        UserService::class => UserServiceImpl::class,
        UserRepository::class => UserRepositoryImpl::class,
        FunclocService::class => FunclocServiceImpl::class,
        FunclocRepository::class => FunclocRepositoryImpl::class,
        MotorService::class => MotorServiceImpl::class,
        MotorRepository::class => MotorRepositoryImpl::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
