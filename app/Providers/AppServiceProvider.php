<?php

namespace App\Providers;

use App\Repositories\FindingRepository;
use App\Repositories\FunclocRepository;
use App\Repositories\Impl\FindingRepositoryImpl;
use App\Repositories\Impl\FunclocRepositoryImpl;
use App\Repositories\Impl\MotorDetailRepositoryImpl;
use App\Repositories\Impl\MotorRecordRepositoryImpl;
use App\Repositories\Impl\MotorRepositoryImpl;
use App\Repositories\Impl\RoleRepositoryImpl;
use App\Repositories\Impl\UserRepositoryImpl;
use App\Repositories\MotorDetailRepository;
use App\Repositories\MotorRecordRepository;
use App\Repositories\MotorRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\FindingService;
use App\Services\FunclocService;
use App\Services\Impl\FindingServiceImpl;
use App\Services\Impl\FunclocServiceImpl;
use App\Services\Impl\MotorDetailServiceImpl;
use App\Services\Impl\MotorRecordServiceImpl;
use App\Services\Impl\MotorServiceImpl;
use App\Services\Impl\RoleServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\MotorDetailService;
use App\Services\MotorRecordService;
use App\Services\MotorService;
use App\Services\RoleService;
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
        MotorDetailService::class => MotorDetailServiceImpl::class,
        MotorDetailRepository::class => MotorDetailRepositoryImpl::class,
        RoleService::class => RoleServiceImpl::class,
        RoleRepository::class => RoleRepositoryImpl::class,
        MotorRecordService::class => MotorRecordServiceImpl::class,
        MotorRecordRepository::class => MotorRecordRepositoryImpl::class,
        FindingService::class => FindingServiceImpl::class,
        FindingRepository::class => FindingRepositoryImpl::class,
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
