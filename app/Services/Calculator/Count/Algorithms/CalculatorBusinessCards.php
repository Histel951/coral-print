<?php

namespace App\Services\Calculator\Count\Algorithms;

use App\Models\Calculator as CalculatorModel;

class CalculatorBusinessCards extends CalculatorMaster
{
    public function getBeforeTotal(
        object $parameters = new \stdClass(),
        CalculatorModel $calculator = new CalculatorModel(),
        $flag = false,
    ): Calculator {
        if (!isset($this->calculable['print'])) {
            $this->calculable['print']['width'] = 320;
            $this->calculable['print']['height'] = 450;
        }

        //set departure if not exists
        $departure = 2;
        if (
            isset($calculator->parameters['big_departure_print_forms']) &&
            isset($parameters->form) &&
            in_array($parameters->form, $calculator->parameters['big_departure_print_forms'])
        ) {
            $departure = 10;
        }
        if ($flag) {
            $this->setDeparture($departure);
        }

        return $this;
    }

    protected function calcTotalPrice(): float
    {
        $this->calculable['total_price'] = $this->calculable['count_item_price'] * $this->calculable['product_count'];

        if (isset($this->calculable['addition_types_price'])) {
            $this->calculable['total_price'] += $this->calculable['addition_types_price'];
        }

        return $this->calculable['total_price'];
    }
}
