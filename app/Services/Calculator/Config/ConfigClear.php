<?php

namespace App\Services\Calculator\Config;

trait ConfigClear
{
    /**
     * Убирает лишние пустые поля: значения из результатного массива (если они пустые или не имеют данных)
     * @param array $result
     * @return array
     */
    private function cleanFields(array $result): array
    {
        $result['data'] = array_filter(
            $result['data'],
            static function ($value) {
                return (bool) count($value);
            },
            ARRAY_FILTER_USE_BOTH,
        );

        foreach ($result['formSchema']['fields'] as $key => $field) {
            if (isset($field['dataField'])) {
                if (!array_key_exists($field['dataField'], $result['data'])) {
                    unset($result['formSchema']['fields'][$key]);
                }
            }
        }

        return $result;
    }
}
