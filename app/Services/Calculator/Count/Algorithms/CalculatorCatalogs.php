<?php

namespace App\Services\Calculator\Count\Algorithms;

use App\Models\Color;

class CalculatorCatalogs extends CalculatorMaster
{
    public function getBeforeTotal(object $parameters = new \stdClass()): Calculator
    {
        if (!isset($this->calculable['departure'])) {
            $this->setDeparture();
        }
        $this->setLayoutPrintCount();
        //count items_on_page and material_count
        if (!isset($this->calculable['items_on_page'])) {
            if (!isset($this->calculable['print'])) {
                $this->calculable['print']['width'] = 310;
                $this->calculable['print']['height'] = 440;
            }
            $this->getItemsOnPage();

            if (isset($this->calculable['part']) and $this->calculable['part'] === 'block') {
                if (isset($parameters->color_block_select)) {
                    $color = Color::query()->find($parameters->color_block_select);

                    if ($color->is_two_side) {
                        $this->modifyCalculableProp('items_on_page', '*', 2);
                    }
                }

                $calculator = \App\Models\Calculator::query()->find($parameters->calculator_id);

                if (
                    isset($calculator->parameters['is_two_side_print']) and $calculator->parameters['is_two_side_print']
                ) {
                    $this->modifyCalculableProp('items_on_page', '*', 2);
                }
            }

            $this->setMaterialCount();
            if (isset($this->calculable['plastic'])) {
                $materials = ['plastic'];
                $this->countMaterialPrice('plastic');
                if (isset($this->calculable['paper'])) {
                    $this->countMaterialPrice('paper');
                    $materials[] = 'paper';
                }
                $this->countAllMaterialPrice($materials);
            } else {
                $this->countMaterialPrice();
            }
        }
        return $this;
    }
}
