<?php

namespace App\Repositories\Knifes;

use App\Models\Calculator;
use App\Models\PrintForm;
use App\Models\RapportKnife;
use App\Services\ModelTextMessage;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

class RapportKnifeRepository implements RapportKnifeRepositoryInterface
{
    /**
     * Возвращает все ножи
     * @param Calculator $calculator
     * @param PrintForm $printForm
     * @return Collection
     * @throws BindingResolutionException
     */
    public function knifes(Calculator $calculator, PrintForm $printForm): Collection
    {
        $query = RapportKnife::query();

        $query->where('print_form_id', $printForm->id);

        $modelTextMessage = app()->make(ModelTextMessage::class, [
            'calculator' => $calculator,
        ]);

        return $query->get()->map(function (RapportKnife $knife) use ($modelTextMessage, $printForm) {
            if ($knife->radius) {
                $knife->isUsePostTextIcon = true;
            }

            $modelTextMessage->changeAllFields($knife, $printForm->id);

            return $knife;
        });
    }
}
