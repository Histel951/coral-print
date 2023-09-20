<?php

namespace App\Services\Calculator\Count\Algorithms;

use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;

interface Calculator
{
    /**
     * @param string $materialId
     * @param string $material_name
     * @return Calculator
     */
    public function setMaterial(string $materialId, string $material_name = 'material'): Calculator;

    /**
     * @param int $printId
     * @return Calculator
     * @throws PrintSizeException
     */
    public function setPrint(int $printId): Calculator;

    /**
     * @param int $addJobId
     * @param int $times
     * @return Calculator
     */
    public function setAddJob(int $addJobId, int $times = 1): Calculator;

    /**
     * @return array
     */
    public function getCalculable(): array;

    /**
     * @return Calculator
     */
    public function debugOn(): Calculator;

    /**
     * @return float
     */
    public function getTotalPrice(): float;

    /**
     * Устанавливает количество продукции
     * @param int $count
     * @return Calculator
     */
    public function setProductCount(int $count): Calculator;
}
