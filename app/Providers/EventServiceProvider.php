<?php

namespace App\Providers;

use App\Events\CalculatorTooltipCacheClearEvent;
use App\Events\CalculatorTypesCacheClearEvent;
use App\Events\MaterialCacheClearEvent;
use App\Events\PreviewCacheClearEvent;
use App\Events\SpecieTypeCacheClearEvent;
use App\Events\WorkAdditionalCacheClearEvent;
use App\Listeners\CalculatorTooltipCacheClearListener;
use App\Listeners\CalculatorTypesCacheClearListener;
use App\Listeners\MaterialCacheClearListener;
use App\Listeners\PreviewCacheClearListener;
use App\Listeners\SpecieTypeCacheClearListener;
use App\Listeners\WorkAdditionalCacheClearListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
        MaterialCacheClearEvent::class => [MaterialCacheClearListener::class],
        SpecieTypeCacheClearEvent::class => [SpecieTypeCacheClearListener::class],
        WorkAdditionalCacheClearEvent::class => [WorkAdditionalCacheClearListener::class],
        PreviewCacheClearEvent::class => [PreviewCacheClearListener::class],
        CalculatorTypesCacheClearEvent::class => [CalculatorTypesCacheClearListener::class],
        CalculatorTooltipCacheClearEvent::class => [CalculatorTooltipCacheClearListener::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
