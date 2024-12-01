<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Specialization;
use App\Models\User;
use App\Policies\AppointmentPolicy;
use App\Policies\SpecializationPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Appointment::class => AppointmentPolicy::class,
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
