<?php

namespace App\Listeners;

use App\Events\PreviewCacheClearEvent;
use Illuminate\Support\Facades\Cache;

class PreviewCacheClearListener
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
     * @param  PreviewCacheClearEvent  $event
     * @return void
     */
    public function handle(PreviewCacheClearEvent $event)
    {
        Cache::tags(['calculator', 'controller', 'preview'])->clear();
    }
}
