<?php

namespace App\Services\Calculator\Count\Algorithms;

class CalculatorStickers extends CalculatorMaster
{
    public function getBeforeTotal(): Calculator
    {
        $unit = 'pm';
        $this->getItemsOnPage();
        $this->setLayoutPrintCount();
        if (!isset($this->calculable['print']['height']) || $this->calculable['print']['height'] == 0) {
            $this->setWidePrintWidthHeight();
            $this->setLinearMeters();
            $unit = 'wide';
        }
        $this->setMaterialCount($unit);
        $this->countMaterialPrice();

        return $this;
    }
}
