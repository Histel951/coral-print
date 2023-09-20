<?php

use App\Models\Calculator;
use App\Models\ColorCount;
use App\Models\Preview;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $previews = [
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-books-preview',
                'form_type' => 'booklets',
                'color_count_id' => ColorCount::query()->where('name', '1 сгиб')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-books-down-preview',
                'form_type' => 'booklets_down',
                'color_count_id' => ColorCount::query()->where('name', '1 сгиб')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-books-2-folds-preview',
                'form_type' => 'booklets',
                'color_count_id' => ColorCount::query()->where('name', '2 сгиба')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-books-2-folds-down-preview',
                'form_type' => 'booklets_down',
                'color_count_id' => ColorCount::query()->where('name', '2 сгиба')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-accordion-3-folds-preview',
                'form_type' => 'booklets_bigger',
                'color_count_id' => ColorCount::query()->where('name', '3 сгиба')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-accordion-3-folds-down-preview',
                'form_type' => 'booklets_down_bigger',
                'color_count_id' => ColorCount::query()->where('name', '3 сгиба')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-vip-4-folds-preview',
                'form_type' => 'booklets_bigger',
                'color_count_id' => ColorCount::query()->where('name', '4 сгиба')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-vip-4-folds-down-preview',
                'form_type' => 'booklets_down_bigger',
                'color_count_id' => ColorCount::query()->where('name', '4 сгиба')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-vip-5-folds-preview',
                'form_type' => 'booklets_bigger',
                'color_count_id' => ColorCount::query()->where('name', '5 сгибов')->first()->id
            ],
            [
                'calculator_id' => 3873,
                'svg_id' => 'booklets-vip-5-folds-down-preview',
                'form_type' => 'booklets_down_bigger',
                'color_count_id' => ColorCount::query()->where('name', '5 сгибов')->first()->id
            ],
        ];

        Preview::query()->where('calculator_id', 3873)->delete();

        foreach ($previews as $preview) {
            $calculator = Calculator::query()->find($preview['calculator_id']);

            Preview::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_type_id' => $calculator->calculatorType->id,
                'svg_id' => $preview['svg_id'],
                'form_type' => $preview['form_type'],
                'color_count_id' => $preview['color_count_id']
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
