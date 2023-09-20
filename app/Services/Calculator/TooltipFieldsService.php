<?php

namespace App\Services\Calculator;

use App\Models\BlockSelectFieldConfig;
use App\Models\Calculator;
use App\Models\FormField;
use App\Models\Tooltip;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TooltipFieldsService
{
    /**
     * Тег кеша @method string label
     * @var string
     */
    public const LABEL_TAG_KEY = ['calculator', 'TooltipFieldsService', 'label'];

    /**
     * Проверяет есть ли поле подсказки в полях табов калькулятора, если есть то добавляет постфикс - название таба
     * @param Tooltip $tooltip
     * @return string
     */
    public function label(Tooltip $tooltip): string
    {
        $cacheKey = cache_key(implode(':', self::LABEL_TAG_KEY), [
            'tooltip_id' => $tooltip->id,
        ]);

        $cache = Cache::tags(self::LABEL_TAG_KEY);

        if (!$cache->has($cacheKey)) {
            $blockSelectFields = $this->getAllBlockSelectFields($tooltip);
            $field = $blockSelectFields->where('id', $tooltip->field->id)->first();
            $cache->put($cacheKey, $field, now()->addWeek());
        } else {
            $field = $cache->get($cacheKey);
        }

        if ($field) {
            $name = $field->parameters['label'];
            if (isset($field->parameters['tooltip_field_name'])) {
                $name = $field->parameters['tooltip_field_name'];
            }

            return "$name, $field[block_name]";
        }

        return $tooltip->field->parameters['label'] ?? '';
    }

    /**
     * Получение всех полей табов калькуляторов + добавляет параметр block_name с названием таба к которому относится
     * @param Tooltip $tooltip
     * @return Collection
     */
    private function getAllBlockSelectFields(Tooltip $tooltip): Collection
    {
        $blockSelectFields = [];
        $tooltip->calculatorType->calculators->each(function (Calculator $calculator) use (&$blockSelectFields) {
            $calculator->blockSelectField->each(function (BlockSelectFieldConfig $blockSelectFieldConfig) use (
                &$blockSelectFields,
            ) {
                $fields = $blockSelectFieldConfig
                    ->fields()
                    ->get()
                    ->map(function (FormField $field) use ($blockSelectFieldConfig) {
                        $field->block_name = $blockSelectFieldConfig->type->name;

                        return $field;
                    });

                $blockSelectFields = Arr::collapse([$blockSelectFields, $fields]);
            });
        });

        return collect($blockSelectFields)->unique('id');
    }
}
