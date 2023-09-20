<?php

namespace App\Listeners;

use App\Events\CalculatorTooltipCacheClearEvent;
use App\Services\Calculator\TooltipFieldsService;
use Illuminate\Support\Facades\Cache;

class CalculatorTooltipCacheClearListener
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
     * @param  CalculatorTooltipCacheClearEvent  $event
     * @return void
     */
    public function handle(CalculatorTooltipCacheClearEvent $event): void
    {
        Cache::tags(TooltipFieldsService::LABEL_TAG_KEY)->clear();
    }
}
