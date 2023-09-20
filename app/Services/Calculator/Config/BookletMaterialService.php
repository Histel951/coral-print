<?php

namespace App\Services\Calculator\Config;

use App\Models\Color;
use App\Models\Lamination;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use stdClass;

class BookletMaterialService extends CalculatorMaterialService
{
    /**
     * Возвращает материал в зависимости от ширины/высоты/цвета печати
     * @param array|null $parameters
     * @param array $whereParams
     * @return array
     */
    public function materials(array|null $parameters = [], array $whereParams = []): array
    {
        $material = $this->getBySpecieType('materials', Material::class, $parameters);

        if ($material instanceof Builder) {
            return $this->materialStruct($material);
        }

        return $material;
    }

    public function laminations(array $parameters = []): array
    {
        $laminations = $this->getBySpecieType('laminations', Lamination::class, $parameters);

        if ($laminations instanceof Builder) {
            return $laminations->get()->toArray();
        }

        return $laminations;
    }

    private function getBySpecieType(string $defaultMethod, string $modelClass, array $parameters = []): array|Builder
    {
        if (
            !is_null($parameters) &&
            ((isset($parameters['width']) && (int) $parameters['width']) ||
                (isset($parameters['height']) && (int) $parameters['height']))
        ) {
            $specieType = $this->specieType(
                width: (int) $parameters['width'],
                height: (int) $parameters['height'],
                colorId: isset($parameters['print_select']) ? (int) $parameters['print_select'] : null,
            );

            return $modelClass::query()->where('print_specie_id', $specieType->print_specie_id);
        }

        return $this->{$defaultMethod}($parameters);
    }

    /**
     * Производит выборку печатей в зависимости от калькулятора и переданного цвета + размер печати
     * Находит ближайшее значение по наибольшему размеру высоты/ширины и берёт ближайшую печать
     * @param int $width
     * @param int $height
     * @param int|null $colorId
     * @return stdClass|null
     */
    public function specieType(int $width, int $height, int $colorId = null): stdClass|null
    {
        $wherePrint = '';
        if ($colorId) {
            $color = Color::find($colorId);
            $wherePrint = "and pcst.print_id = {$color->print_id}";
        }

        $biggerHW = max($width, $height);
        $biggerSpecieTypes = collect(
            DB::select("
                          select
                                IF(st.width > st.height, st.width, st.height) bigger,
                                IF(st.width > st.height, 'width', 'height') bigger_field,
                                st.id as id,
                                pcst.is_duplex,
                                st.print_specie_id
                          from pivot_calculator_specie_types pcst
                                left join specie_types st
                                    on pcst.specie_type_id = st.id
                                where pcst.calculator_id = {$this->calculator->id}
                                  {$wherePrint}
                          order by bigger
                                "),
        );

        $nearBigger = null;
        if ($biggerSpecieTypes->count() > 1) {
            foreach ($biggerSpecieTypes->pluck('bigger') as $bigger) {
                if ($bigger >= $biggerHW) {
                    $nearBigger = $bigger;
                    break;
                }
            }
        } else {
            $nearBigger = $biggerSpecieTypes->first()->bigger;
        }

        if (!$nearBigger) {
            return $biggerSpecieTypes->last();
        }

        return $biggerSpecieTypes->where('bigger', $nearBigger)->first();
    }
}
