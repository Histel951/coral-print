<?php

namespace App\Orchid\Module\Print;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

/**
 * Сохраняет в куки GET параметрами последних страниц для перемещения по админке
 * @package PrintBreadCrumbs
 */
class PrintBreadCrumbs
{
    /**
     * @param BreadCrumbsCookie $cookie
     * @param int $seconds
     * @return void
     */
    public static function set(BreadCrumbsCookie $cookie, int $seconds = 3660): void
    {
        Cache::put(
            self::getKey($cookie),
            json_encode([
                'parameters' => Request::all(),
                'name' => Request::route()->getName(),
            ]),
            $seconds,
        );
    }

    /**
     * @param BreadCrumbsCookie $cookie
     * @return string[]
     */
    public static function get(BreadCrumbsCookie $cookie): array
    {
        return json_decode(Cache::get(self::getKey($cookie)), true) ?? [];
    }

    /**
     * Формирует ключ для получения куки
     * @param BreadCrumbsCookie $cookie
     * @return string
     */
    private static function getKey(BreadCrumbsCookie $cookie): string
    {
        $userId = Auth::id();
        return "{$cookie->value}:{$userId}";
    }
}
