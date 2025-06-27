<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Credit;
use App\Models\EnergyMeter;
use App\Models\EnergyReading;
use App\Models\EnergyProvider;
use App\Policies\CreditPolicy;
use App\Policies\EnergyMeterPolicy;
use App\Policies\EnergyReadingPolicy;
use App\Policies\EnergyProviderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Credit::class => CreditPolicy::class,
        EnergyMeter::class => EnergyMeterPolicy::class,
        EnergyReading::class => EnergyReadingPolicy::class,
        EnergyProvider::class => EnergyProviderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
