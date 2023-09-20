<?php

namespace App\Listeners;

use App\Events\SpecieTypeCacheClearEvent;
use Illuminate\Support\Facades\Cache;

class SpecieTypeCacheClearListener
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
     * @param SpecieTypeCacheClearEvent $event
     * @return void
     */
    public function handle(SpecieTypeCacheClearEvent $event)
    {
        Cache::tags(['calculatorMaster', 'setMaterial', 'specie_type'])->clear();
        Cache::tags(['calculator', 'specie_type'])->clear();
    }
}
