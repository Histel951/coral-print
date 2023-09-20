<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\Pages\Block;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        Blade::directive('content', function (int $contentId) {
            $page = Content::where('content_id', with($contentId))->first();

            return $page?->content;
        });

        Blade::directive('block', function (string $alias) {
            $block = Block::where('alias', substr($alias, 1, -1))->first();

            return $block?->content;
        });
    }
}
