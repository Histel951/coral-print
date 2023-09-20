<?php

namespace App\Services\Calculator\Config;

use App\Models\CalculatorSub;
use App\Models\MaterialType;
use Illuminate\Support\Facades\Cache;

class TagLabelMaterialService extends CalculatorMaterialService
{
    /**
     * Тип материала по которому подтягиваются значения
     * @var string
     */
    protected string $materialType = 'flex';

    /**
     * Возвращает только материалы флексы
     * @param array|null $parameters
     * @param array $whereParams
     * @return array
     */
    public function materials(?array $parameters = [], array $whereParams = []): array
    {
        $cacheKey = cache_key('service:material:materials', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
            'print_type' => $parameters['print_type'] ?? null,
            'target_calculator_id' => $parameters['calculator']?->id ?? null
        ]);

        $cache = Cache::tags(['service', 'material', 'materials']);

        return $cache->remember($cacheKey, now()->addDays(2), function () {
            $materialTypesTable = (new MaterialType())->getTable();
            $materialsBuilder = $this->calculator->materials()
                ->join(
                    $materialTypesTable,
                    "$materialTypesTable.name",
                    '=',
                    $this->materialType,
                    'left',
                    true
                )
                ->where('materials.is_show', '=', true)
                ->whereColumn('materials.material_type_id', '=', "$materialTypesTable.id");
            return $this->materialStruct($materialsBuilder);
        });
    }
}
