<?php

namespace App\Services\Calculator\Count\Algorithms;

class CalculatorWide extends CalculatorMaster
{
    public function getBeforeTotal(): Calculator
    {
        if (!isset($this->calculable['items_on_page'])) {
            $unit = 'pm';
            if ($this->calculable['type'] != 'banner') {
                $this->getItemsOnPage();
            } else {
                $unit = 'banner';
            }
            $this->setLayoutPrintCount(false);
            if (
                (!isset($this->calculable['print']['height']) || $this->calculable['print']['height'] == 0) &&
                $this->calculable['type'] != 'banner'
            ) {
                $this->setWidePrintWidthHeight();
                $this->setLinearMeters();
                $unit = 'wide';
            }
            $this->setMaterialCount($unit);
            $this->countMaterialPrice();
            if (isset($_POST['knurling'])) {
                $this->modifyCalculableProp('material_price_total', '*', 2);
                $this->modifyCalculableProp('total_material_cost', '*', 2);
            }
        }
        return $this;
    }
}
