<?php

namespace App\Services;

use App\Models\RapportKnife;

interface RapportKnifeServiceInterface
{
    /**
     * Создаёт и возвращает номер ножа
     * @param RapportKnife $knife
     * @return string
     */
    public function createRapportKnifeNumber(RapportKnife $knife): string;

    /**
     * Удаляет номер ножа
     * @param RapportKnife $knife
     * @return bool
     */
    public function removeRapportKnifeNumber(RapportKnife $knife): bool;
}
