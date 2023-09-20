<?php

namespace App\Repositories\Knifes;

use App\Models\Calculator;
use App\Models\PrintForm;
use Illuminate\Support\Collection;

interface RapportKnifeRepositoryInterface
{
    /**
     * Возвращает все ножи
     * @param Calculator $calculator
     * @param PrintForm $printForm
     * @return Collection
     */
    public function knifes(Calculator $calculator, PrintForm $printForm): Collection;
}
