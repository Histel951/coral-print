<?php

namespace App\Listeners;

use App\Events\WorkAdditionalCacheClearEvent;
use Illuminate\Support\Facades\Cache;

class WorkAdditionalCacheClearListener
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
     * @param WorkAdditionalCacheClearEvent $event
     * @return void
     */
    public function handle(WorkAdditionalCacheClearEvent $event)
    {
        Cache::tags(['workAdditional', 'service', 'find'])->clear();
        Cache::tags(['calculatorMaster', 'setAddJob', 'work_additional'])->clear();
    }
}
