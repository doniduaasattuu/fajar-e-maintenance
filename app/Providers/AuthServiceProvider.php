<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Document;
use App\Models\Finding;
use App\Models\PubShare;
use App\Policies\DocumentPolicy;
use App\Policies\FindingPolicy;
use App\Policies\PubSharePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Document::class => DocumentPolicy::class,
        Finding::class => FindingPolicy::class,
        PubShare::class => PubSharePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
