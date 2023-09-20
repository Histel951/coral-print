<?php

namespace App\Services\Calculator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait FieldTrait
{
    /**
     * Формирует структурированый по категориям массив материалов
     * @param BelongsToMany|HasMany|Builder $builder
     * @return array
     */
    protected function materialStruct(BelongsToMany|HasMany|Builder $builder): array
    {
        $builder = $builder->distinct();

        return array_values(
            $builder
                ->with(['category', 'materialSubTypes' => fn ($query) => $query->orderBy('sequence')])
                ->orderBy('sequence')
                ->get()
                ->mapToGroups(static function ($item) {
                    $item->materialSubTypes->map(static function ($type) use ($item) {
                        if ((int)$item->is_hex) {
                            $type->is_image = false;
                            $type->image_url = '';
                        } else {
                            $type->is_image = true;
                            $type->image_url = $type->image->url();
                        }

                        return $type;
                    });
                    $item->types = $item->materialSubTypes;
                    unset($item->materialSubTypes);

                    if (!isset($item['category']['name'])) {
                        return ['Без категории' => $item];
                    }

                    return [$item['category']['name'] => $item];
                })
                ->map(static function ($item, $key) {
                    return [
                        'category' => $key,
                        'items' => $item->toArray(),
                    ];
                })
                ->toArray(),
        );
    }
}
