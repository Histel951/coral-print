<?php

namespace App\Listeners;

use App\Events\MaterialCacheClearEvent;
use Illuminate\Support\Facades\Cache;

class MaterialCacheClearListener
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
     * @param MaterialCacheClearEvent $event
     * @return void
     */
    public function handle(MaterialCacheClearEvent $event)
    {
        Cache::tags(['service', 'material', 'materials'])->clear();
        Cache::tags(['calculatorMaster', 'setMaterial', 'material'])->clear();
    }
}
