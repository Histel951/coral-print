<?php

namespace App\Listeners;

use App\Events\CalculatorTypesCacheClearEvent;
use Illuminate\Support\Facades\Cache;

class CalculatorTypesCacheClearListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CalculatorTypesCacheClearEvent  $event
     * @return void
     */
    public function handle(CalculatorTypesCacheClearEvent $event): void
    {
        Cache::tags(['calculator', 'controller', 'types'])->clear();
    }
}
