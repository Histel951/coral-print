<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allCalculatorIds = \App\Models\Calculator::query()->where('calculator_type_id', 3854)->pluck('id');

        \App\Models\PivotCalculatorFoiling::query()->whereIn('calculator_id', $allCalculatorIds)->delete();

        $noFoiling = \App\Models\Foiling::query()->create([
            'name' => 'Без фольги, только печать',
        ]);

        $onlyFoilingNoPrint = \App\Models\Foiling::query()->create([
            'name' => 'Только фольга, без печати'
        ]);

        $onlyFoilingWithPrint = \App\Models\Foiling::query()->create([
            'name' => 'Отделка фольгой + печать'
        ]);

        $file = new \Illuminate\Http\UploadedFile(public_path('/images/foilings/no-color.svg'), 'no-color.svg');
        $attachment = (new \Orchid\Attachment\File($file))->load();

        foreach ([$onlyFoilingNoPrint, $onlyFoilingWithPrint] as $foiling) {
            $allFoilingColors = \App\Models\FoilingColor::query()->whereNotNull('image_id')->pluck('id');

            $allFoilingColors->map(fn (int $foilingColorId) => \App\Models\PivotFoilingColor::query()->create([
                'foiling_color_id' => $foilingColorId,
                'foiling_id' => $foiling->getKey()
            ]));
        }

        $noFoilingColor = \App\Models\FoilingColor::query()->create([
            'image_id' => $attachment->getKey(),
            'name' => 'Без цвета'
        ]);

        \App\Models\PivotFoilingColor::query()->create([
            'foiling_id' => $noFoiling->getKey(),
            'foiling_color_id' => $noFoilingColor->getKey()
        ]);

        $allFoilings = [$noFoiling, $onlyFoilingNoPrint, $onlyFoilingWithPrint];
        foreach ($allCalculatorIds as $calculatorId) {
            foreach ($allFoilings as $foiling) {
                \App\Models\PivotCalculatorFoiling::query()->create([
                    'calculator_id' => $calculatorId,
                    'foiling_id' => $foiling->getKey(),
                    'calculator_sub_id' => 1
                ]);
            }
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
