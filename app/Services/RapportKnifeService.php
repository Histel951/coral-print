<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Rapport;
use App\Models\RapportKnife;

class RapportKnifeService implements RapportKnifeServiceInterface
{
    /**
     * Создаёт и возвращает номер (КВ) ножа
     * @param RapportKnife|int $knife
     * @return string
     */
    public function createRapportKnifeNumber(RapportKnife|int $knife): string
    {
        $knife = $this->knife($knife);
        $number = 1;
        $knifes = Rapport::find($knife->rapport_id)->knifes()->whereNotNull('knife_number_summary');

        if ($knifes->count()) {
            $allNumbers = [];
            $knifes->each(function (RapportKnife $rapportKnife) use (&$allNumbers) {
                $allNumbers[] = explode('-', $rapportKnife->knife_number_summary)[1];
            });

            $number = max($allNumbers) + 1;
        }

        $knife->isset_knife = true;
        $knife->knife_number_summary = "{$knife->rapport->name}-$number";
        $knife->save();

        return $knife->knife_number_summary;
    }

    /**
     * Удаляет номер ножа
     * @param RapportKnife|int $knife
     * @return bool
     */
    public function removeRapportKnifeNumber(RapportKnife|int $knife): bool
    {
        $knife = $this->knife($knife);

        $knife->isset_knife = false;
        $knife->knife_number_summary = null;
        $knife->save();

        return !$knife->isset_knife;
    }

    private function knife(RapportKnife|int $knife): RapportKnife
    {
        if (!($knife instanceof RapportKnife)) {
            $knife = RapportKnife::find($knife);
        }

        return $knife;
    }
}
