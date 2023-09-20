<?php

namespace App\Services\Calculator\Count\Algorithms;

class CalculatorTags extends CalculatorMaster
{
    public function getBeforeTotal(): Calculator
    {
        if (!isset($this->calculable['print'])) {
            $this->calculable['print']['width'] = 320;
            $this->calculable['print']['height'] = 450;
        }
        //set departure if not exists
        //        $departure=10;
        //        if ($_POST['type']==='simple_tags' || $_POST['type']==='simple_wobblers') {
        //            $departure = 2;
        //        }
        //        if (!isset($this->calculable['departure'])) {
        //            $this->setDeparture($departure);
        //        }
        return $this;
    }
}
