<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use App\Models\Preview;
use App\Models\PreviewPrintSizePixel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Формирует и возвращает массив с превью
 * @package CalculatorPreviewService
 */
class CalculatorPreviewService implements PreviewService
{
    /**
     * Тег кеша для подтягивания и записи данных
     * @var string[]
     */
    private const CACHE_TAGS = ['calculator', 'controller', 'preview'];

    /**
     * Параметры по которым происходит поиск нужных превью на фронте
     * Сопоставляет название полей в форме с полями из базы
     * Название полей в форме => поля со значениями из базы
     * @var string[]
     */
    private const PARAMETERS_FIELDS = [
        'cutting' => 'cutting_id',
        'form' => 'form_id',
        'volume' => 'is_volume',
        'mounting_film' => 'is_mounting_film',
        'rounding_corners' => 'is_rounding_corners',
        'fold_count' => 'folds',
    ];

    /**
     *  Возвращает массив превью продукта калькулятора
     * @param Calculator $calculator
     * @param array $whereParams
     * @return array
     */
    public function get(Calculator $calculator, array $whereParams = []): array
    {
        $cacheKey = cache_key(implode(':', self::CACHE_TAGS), $whereParams);
        $cache = Cache::tags(self::CACHE_TAGS);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey)->toArray();
        }

        $previewQuery = $this->getQuery($whereParams);
        $result = $this->getResult($calculator, $previewQuery->get());
        $result = $this->getParameters($result);

        $cache->put($cacheKey, $result, now()->addDays(2));

        return $result->toArray();
    }

    /**
     * Назначает коллекцию параметров для поиска превью на фронте
     * @param Collection $resultPreviews результат выборки превью
     * @return Collection
     */
    public function getParameters(Collection $resultPreviews): Collection
    {
        $fields = Schema::getColumnListing((new Preview())->getTable());

        return $resultPreviews->map(function (array $preview) use ($fields): array {
            $preview['parameters'] = [];

            foreach (self::PARAMETERS_FIELDS as $formField => $databaseField) {
                if (!in_array($databaseField, $fields) and !isset($preview->{$databaseField})) {
                    continue;
                }

                $preview['parameters'][$formField] = $preview[$databaseField];
            }

            return $preview;
        });
    }

    /**
     * Формирует sql запрос по таблице превью
     * @param array $whereParams
     * @return Builder
     */
    private function getQuery(array $whereParams): Builder
    {
        $query = Preview::query()
            ->orderBy('sequence')
            ->with(['previewPrintSizePixels', 'bracer']);

        foreach ($whereParams as $field => $value) {
            $query->where($field, $value);
        }

        return $query;
    }

    /**
     * Формирует и возвращает результат выборки
     * @param Calculator $calculator
     * @param Collection $previews
     * @return Collection
     */
    private function getResult(Calculator $calculator, Collection $previews): Collection
    {
        $previewsType = $this->getPreviewsType($calculator);

        return $previews->map(static function (Preview $preview) use ($previewsType): array {
            $pixels = $preview->previewPrintSizePixels->map(
                static fn (PreviewPrintSizePixel $pixel): array => [
                    'width_px' => $pixel->pixels_w,
                    'height_px' => $pixel->pixels_h,
                    'print_size' => [
                        'id' => $pixel->printSize->id,
                        'name' => $pixel->printSize->name,
                        'short_name' => $pixel->printSize->short_name,
                        'height' => $pixel->printSize->height,
                        'width' => $pixel->printSize->width,
                    ],
                ],
            );

            $preview['type'] = $previewsType;

            return Arr::collapse([
                [
                    'url' => $preview->previewImage?->url(),
                    'pixels' => $pixels,
                ],
                $preview->toArray(),
            ]);
        });
    }

    /**
     * Возвращает тип превью, глобально для раздела (статическое/изменяемое - по размерам)
     * @param Calculator $calculator
     * @return string
     */
    private function getPreviewsType(Calculator $calculator): string
    {
        $type = $calculator->calculatorType->previewOptions?->parameters_type;

        if (!$type) {
            $type = 'default';
        }

        return $type;
    }
}
