<?php

namespace App\Services;

use App\Models\Promocode;
use Illuminate\Support\Str;

final class PromocodeService
{
    public const DEFAULT_DISCOUNT = 10;

    public const SOURCE_YANDEX = 1;
    public const SOURCE_GOOGLE = 2;
    public const SOURCE_INSTAGRAM = 3;
    public const SOURCE_PERSONAL = 4;
    public const SOURCE_SITE = 5;

    /**
     * @param int $status
     * @return string
     */
    public function getSourceText(int $source): string
    {
        $sources = [
            self::SOURCE_YANDEX => 'Яндекс',
            self::SOURCE_GOOGLE => 'Гугол',
            self::SOURCE_INSTAGRAM => 'Инстаграм',
            self::SOURCE_PERSONAL => 'Персональная',
            self::SOURCE_SITE => 'Сайт',
        ];

        return $sources[$source] ?? $sources[self::SOURCE_SITE];
    }

    public function getSources(): array
    {
        return [
            self::SOURCE_YANDEX => 'Яндекс',
            self::SOURCE_GOOGLE => 'Гугол',
            self::SOURCE_INSTAGRAM => 'Инстаграм',
            self::SOURCE_PERSONAL => 'Персональная',
            self::SOURCE_SITE => 'Сайт',
        ];
    }

    public function getAvailibleSources(): array
    {
        return [
            self::SOURCE_YANDEX => 'Яндекс',
            self::SOURCE_GOOGLE => 'Гугол',
            self::SOURCE_INSTAGRAM => 'Инстаграм',
            self::SOURCE_PERSONAL => 'Персональная',
        ];
    }

    /**
     * @return array
     */
    public function getDisbledPromodes(): array
    {
        return array_column(
            Promocode::disabled()
                ->get('name')
                ->toArray(),
            'name',
        );
    }

    /**
     * @return string
     */
    public function getNewCode()
    {
        $code = Str::upper(Str::random(7));
        if (
            Promocode::all()
                ->pluck('value')
                ->contains($code)
        ) {
            return $this->getNewCode();
        }

        return $code;
    }

    /**
     * @param ?string $code
     * @return int
     */
    public function getPromocodeCount(?string $code): int
    {
        return Promocode::where('value', strtoupper($code))->count();
    }
}
