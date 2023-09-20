<?php

use App\Models\Calculator;
use App\Models\PrintForm;
use App\Models\RapportKnife;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = Calculator::query()->whereIn('name', [
            'На прозрачной плёнке с белым',
            'Этикетки с персонализацией',
            'Термоэтикетка'
        ]);

        $modelTextEtiketki = [
            [
                'print_form_id' => PrintForm::query()->where('name', 'Прямоугольная')->first()->id,
                'fields' => [
                    'postText' => 'R=#radius# мм',
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => true
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Овальная')->first()->id,
                'fields' => [
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => false
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Прямоугольная')->first()->id,
                'fields' => [
                    'postNameText' => ', углы ',
                ],
                'is_int' => false
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Круглая')->first()->id,
                'fields' => [
                    'name' => '#width# мм'
                ],
                'is_int' => false
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Сложная')->first()->id,
                'fields' => [
                    'prevText' => '«#description#», ',
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => false
            ]
        ];

        $calculators->each(function (Calculator $calculator) use ($modelTextEtiketki): void {
            $calculator->modelTextDataMessage()->detach();

            foreach ($modelTextEtiketki as $item) {
                $this->setTextField($calculator, $item['fields'], $item['is_int'], $item['print_form_id']);
            }
        });
    }

    private function setTextField(Calculator $calculator, array $fields, bool $isInt, int $printFormId): void
    {
        foreach ($fields as $fieldName => $message) {
            $newModelTextData = $calculator->modelTextDataMessage()->create([
                'message' => $message,
                'model_class' => RapportKnife::class
            ]);

            $calculator->modelTextDataMessage()->updateExistingPivot($newModelTextData, [
                'model_field' => $fieldName,
                'is_int' => $isInt,
                'print_form_id' => $printFormId
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
