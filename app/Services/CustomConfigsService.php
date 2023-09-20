<?php

namespace App\Services;

use App\Models\CustomConfig;
use Illuminate\Support\Facades\Cache;

class CustomConfigsService implements CustomConfigs
{
    /**
     * Получение значения конфига
     * @param string $name
     * @return mixed
     */
    public function get(string $name): mixed
    {
        $cacheKey = cache_key('custom:configs:get', [
            'name' => $name,
        ]);

        $cache = Cache::tags(['custom', 'config', 'get']);

        return $cache->remember(
            $cacheKey,
            now()->addDays(7),
            static fn () => CustomConfig::where('name', $name)->first()?->value,
        );
    }

    /**
     * Устанавливает значение для конфига
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, mixed $value): void
    {
        CustomConfig::create([
            'name' => $name,
            'value' => (string) $value,
        ]);
    }
}
