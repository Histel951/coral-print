<?php

use App\Models\Calculator;
use App\Models\CalculatorSub;
use App\Models\Foiling;
use App\Models\FoilingColor;
use App\Models\PivotCalculatorFoiling;
use App\Models\PivotFoilingColor;
use App\Models\PivotWorkAdditional;
use App\Models\WorkAdditional;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = Calculator::query()->whereIn('id', [3836]);

        $notEmbossing = Foiling::query()->create([
            'name' => 'Без тиснения',
            'sequence' => 1,
            'is_none' => true
        ]);

        $embossingFoiling = Foiling::query()->create([
            'name' => 'Тиснение фольгой',
            'sequence' => 2
        ]);

        $stampingFoiling = Foiling::query()->create([
            'name' => 'Конгрев фольгой',
            'sequence' => 3,
            'is_congregation' => true
        ]);

        $stampingNotFoiling = Foiling::query()->create([
            'name' => 'Конгрев без фольги',
            'sequence' => 4,
            'is_congregation' => true
        ]);

        $bronseImage = $this->setColorImage('bronse.svg');
        $mateBronseImage = $this->setColorImage('mate-bronse.svg');
        $mateGoldImage = $this->setColorImage('mate-gold.svg');
        $mateSilverImage = $this->setColorImage('mate-silver.svg');
        $noColorStar = $this->setColorImage('no-color-star.svg');

        $glossyGold = FoilingColor::query()->create([
            'name'  => 'Глянцевое золото',
            'image_id' => FoilingColor::query()->find(64)?->image_id
        ]);

        $glossySilver = FoilingColor::query()->create([
            'name'  => 'Глянцевое серебро',
            'image_id' => FoilingColor::query()->find(65)?->image_id
        ]);

        // добавить картинки
        $glossyCopper = FoilingColor::query()->create([
            'name' => 'Глянцевая медь',
            'image_id' => $bronseImage->getKey()
        ]);

        $matteGold = FoilingColor::query()->create([
            'name' => 'Матовое золото',
            'image_id' => $mateGoldImage->getKey()
        ]);

        $matteSilver = FoilingColor::query()->create([
            'name'  => 'Матовое серебро',
            'image_id' => $mateSilverImage->getKey()
        ]);

        // добавить картинки
        $matteCopper = FoilingColor::query()->create([
            'name' => 'Матовая медь',
            'image_id' => $mateBronseImage->getKey()
        ]);

        $stampingNotColor = FoilingColor::query()->create([
            'name' => 'Без цвета',
            'image_id' => $noColorStar->getKey()
        ]);

        $embossingFoilingColors = [
            [
                'foilings_categories' => [$embossingFoiling->getKey(), $stampingFoiling->getKey()],
                'colors' => [
                    $glossyGold->getKey(),
                    $glossySilver->getKey(),
                    $glossyCopper->getKey(),
                    $matteGold->getKey(),
                    $matteSilver->getKey(),
                    $matteCopper->getKey(),
                ]
            ],
            [
                'foilings_categories' => [$notEmbossing->getKey()],
                'colors' => [88]
            ],
            [
                'foilings_categories' => [$stampingNotFoiling->getKey()],
                'colors' => [$stampingNotColor->getKey()]
            ]
        ];

        foreach ($embossingFoilingColors as $item) {
            foreach ($item['foilings_categories'] as $foilingCategoryId) {
                foreach ($item['colors'] as $colorId) {
                    PivotFoilingColor::query()->create([
                        'foiling_id' => $foilingCategoryId,
                        'foiling_color_id' => $colorId
                    ]);
                }
            }
        }

        $allFoilingCategories = [
            $embossingFoiling->getKey(),
            $stampingFoiling->getKey(),
            $notEmbossing->getKey(),
            $stampingNotFoiling->getKey()
        ];

        $calculators->each(function (Calculator $calculator) use ($allFoilingCategories) {
            foreach ($allFoilingCategories as $categoryId) {
                $calculator->calculatorSubs()->each(fn (CalculatorSub $calculatorSub) => PivotCalculatorFoiling::query()->create([
                    'calculator_id' => $calculator->id,
                    'foiling_id' => $categoryId,
                    'calculator_sub_id' => $calculatorSub->id
                ]));
            }
        });

        $this->setFoilingWorkAdditional($calculators, [$embossingFoiling, $stampingFoiling, $stampingNotFoiling], '#прилтисн');
        $this->setFoilingWorkAdditional($calculators, [$stampingFoiling, $stampingNotFoiling], '#конгреввиз');
        $this->setFoilingWorkAdditional($calculators, [$embossingFoiling], '#тиснвиз');
    }

    /**
     * Добавляет в базу картинку для цвета фольги
     * @param string $fileName
     * @return Attachment
     */
    private function setColorImage(string $fileName): Attachment
    {
        $newFile = new UploadedFile(public_path("images/foilings/{$fileName}"), $fileName);

        return (new File($newFile))->load();
    }

    /**
     * Добавляет доп работы
     * @param Builder $calculators
     * @param Foiling[] $foilings
     * @param string $workAdditionalCode
     * @return void
     */
    private function setFoilingWorkAdditional(Builder $calculators, array $foilings, string $workAdditionalCode): void
    {
        $workAdditional = WorkAdditional::query()->where('code', $workAdditionalCode)->first();

        $calculators->each(function (Calculator $calculator) use ($foilings, $workAdditional) {
            foreach ($foilings as $foiling) {
                PivotWorkAdditional::query()->create([
                    'work_additional_id' => $workAdditional->id,
                    'calculator_id' => $calculator->id,
                    'foiling_id' => $foiling->id
                ]);
            }
        });
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
