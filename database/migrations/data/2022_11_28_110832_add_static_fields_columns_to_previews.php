<?php

use App\Models\Calculator;
use App\Models\Cutting;
use App\Models\Foiling;
use App\Models\PivotCalculatorFoiling;
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
        $allFoilings = Calculator::query()->find(3855)->foilings;

        $allFoilings->each(fn (Foiling $foiling) => PivotCalculatorFoiling::query()->create([
            'foiling_id' => $foiling->id,
            'calculator_id' => 3881,
            'calculator_sub_id' => 1
        ]));

        $newPreviews = [
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-rounded',
                'form_id' => 54,
                'cutting_id' => 2,
                'width' => 173,
                'height' => 152
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-rect',
                'form_id' => 55,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-oval',
                'form_id' => 56,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-cutting-1-rounded',
                'form_id' => 54,
                'cutting_id' => 1,
                'width' => 214,
                'height' => 192
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-cutting-1-rect',
                'form_id' => 55,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-cutting-1-oval',
                'form_id' => 56,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-cutting-4-rounded',
                'form_id' => 54,
                'cutting_id' => 4,
                'width' => 152,
                'height' => 152
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-cutting-4-rect',
                'form_id' => 55,
                'cutting_id' => 4,
                'width' => 152,
                'height' => 152
            ],
            [
                'calculator_id' => 3829,
                'svg_id' => 'white-print-nadsechka-cutting-4-oval',
                'form_id' => 56,
                'cutting_id' => 4,
                'width' => 192,
                'height' => 152
            ],
            // 3819
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-rounded',
                'form_id' => 54,
                'cutting_id' => 2,
                'width' => 173,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-rect',
                'form_id' => 55,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3816-3816-2-preview',
                'form_id' => 55,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-oval',
                'form_id' => 56,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3827-3827-2-preview',
                'form_id' => 56,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'ill-figure-sticker-hand-cut',
                'form_id' => 57,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
            ],
            // 3814-3829-3829-2-preview
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3829-3829-2-preview',
                'form_id' => 57,
                'cutting_id' => 2,
                'width' => 156,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-cutting-1-rounded',
                'form_id' => 54,
                'cutting_id' => 1,
                'width' => 214,
                'height' => 192,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3815-3815-1-preview',
                'form_id' => 54,
                'cutting_id' => 1,
                'width' => 230,
                'height' => 200
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-cutting-1-rect',
                'form_id' => 55,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3816-3816-1-preview',
                'form_id' => 55,
                'cutting_id' => 1,
                'width' => 270,
                'height' => 200
            ],
            // 3814-3816-3816-1-preview
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-cutting-1-oval',
                'form_id' => 56,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3827-3827-1-preview',
                'form_id' => 56,
                'cutting_id' => 1,
                'width' => 270,
                'height' => 200
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nakleek-complex-volume',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3830-3830-1-preview',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-cutting-4-rounded',
                'form_id' => 54,
                'cutting_id' => 4,
                'width' => 152,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3815-3815-4-preview',
                'form_id' => 54,
                'cutting_id' => 4,
                'width' => 152,
                'height' => 152
            ],
            // white-print-nadsechka-cutting-4-rect
            // 230 153
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-cutting-4-rect',
                'form_id' => 55,
                'cutting_id' => 4,
                'width' => 230,
                'height' => 153,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3816-3816-4-preview',
                'form_id' => 55,
                'cutting_id' => 4,
                'width' => 230,
                'height' => 153
            ],
            // white-print-nadsechka-cutting-4-complex
            // 158 154
            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-cutting-4-complex',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 158,
                'height' => 154,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3817-3817-4-preview',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 134,
                'height' => 152,
                'is_volume' => 1
            ],

            [
                'calculator_id' => 3819,
                'svg_id' => 'white-print-nadsechka-cutting-4-oval',
                'form_id' => 56,
                'cutting_id' => 4,
                'width' => 194,
                'height' => 154,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3827-3827-4-preview',
                'form_id' => 56,
                'cutting_id' => 4,
                'width' => 188,
                'height' => 151
            ],
            // 3821
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-rounded',
                'form_id' => 54,
                'cutting_id' => 2,
                'width' => 173,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-rect',
                'form_id' => 55,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3816-3816-2-preview',
                'form_id' => 55,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-oval',
                'form_id' => 56,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3827-3827-2-preview',
                'form_id' => 56,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'ill-figure-sticker-hand-cut',
                'form_id' => 57,
                'cutting_id' => 2,
                'width' => 230,
                'height' => 152,
            ],
            // 3814-3829-3829-2-preview
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3829-3829-2-preview',
                'form_id' => 57,
                'cutting_id' => 2,
                'width' => 156,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-1-rounded',
                'form_id' => 54,
                'cutting_id' => 1,
                'width' => 214,
                'height' => 192,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3815-3815-1-preview',
                'form_id' => 54,
                'cutting_id' => 1,
                'width' => 230,
                'height' => 200
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-1-rect',
                'form_id' => 55,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3816-3816-1-preview',
                'form_id' => 55,
                'cutting_id' => 1,
                'width' => 270,
                'height' => 200
            ],
            // 3814-3816-3816-1-preview
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-1-oval',
                'form_id' => 56,
                'cutting_id' => 1,
                'width' => 261,
                'height' => 192,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3827-3827-1-preview',
                'form_id' => 56,
                'cutting_id' => 1,
                'width' => 270,
                'height' => 200
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3819-3819-1-preview',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 270,
                'height' => 200,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3830-3830-1-preview',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 205,
                'height' => 200,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-4-rounded',
                'form_id' => 54,
                'cutting_id' => 4,
                'width' => 152,
                'height' => 152,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3815-3815-4-preview',
                'form_id' => 54,
                'cutting_id' => 4,
                'width' => 152,
                'height' => 152
            ],
            // white-print-nadsechka-cutting-4-rect
            // 230 153
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-4-rect',
                'form_id' => 55,
                'cutting_id' => 4,
                'width' => 230,
                'height' => 153,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3816-3816-4-preview',
                'form_id' => 55,
                'cutting_id' => 4,
                'width' => 230,
                'height' => 153
            ],
            // white-print-nadsechka-cutting-4-complex
            // 158 154
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-4-complex',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 158,
                'height' => 154,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-4-complex',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 158,
                'height' => 154,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3817-3817-4-preview',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 134,
                'height' => 152,
                'is_volume' => 1
            ],

            [
                'calculator_id' => 3821,
                'svg_id' => 'white-print-nadsechka-cutting-4-oval',
                'form_id' => 56,
                'cutting_id' => 4,
                'width' => 194,
                'height' => 154,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3827-3827-4-preview',
                'form_id' => 56,
                'cutting_id' => 4,
                'width' => 188,
                'height' => 151
            ],
            // 3830
            // 3814-3815-3815-1-preview
            [
                'calculator_id' => 3830,
                'svg_id' => '3814-3815-3815-1-preview',
                'form_id' => 54,
                'cutting_id' => 1,
                'width' => 200,
                'height' => 230
            ],
            [
                'calculator_id' => 3830,
                'svg_id' => '3814-3816-3816-1-preview',
                'form_id' => 55,
                'cutting_id' => 1,
                'width' => 270,
                'height' => 200
            ],
            [
                'calculator_id' => 3830,
                'svg_id' => '3814-3827-3827-1-preview',
                'form_id' => 56,
                'cutting_id' => 1,
                'width' => 270,
                'height' => 200
            ],
            [
                'calculator_id' => 3830,
                'svg_id' => '3814-3817-3817-1-preview',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 184,
                'height' => 200
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'foiling-print-complex-cutting-1',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 206,
                'height' => 201
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3821-3821-1-preview',
                'form_id' => 57,
                'cutting_id' => 1,
                'width' => 213,
                'height' => 192,
                'is_volume' => 1
            ],
            // 3814-3815-3815-2-preview
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3815-3815-2-preview',
                'form_id' => 54,
                'cutting_id' => 2,
                'width' => 152,
                'height' => 174
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'cutting-3-round',
                'form_id' => 54,
                'cutting_id' => 3,
                'width' => 132,
                'height' => 132
            ],
            // cutting-3-rect
            [
                'calculator_id' => 3821,
                'svg_id' => 'cutting-3-rect',
                'form_id' => 55,
                'cutting_id' => 3,
                'width' => 214,
                'height' => 137
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'cutting-3-oval',
                'form_id' => 56,
                'cutting_id' => 3,
                'width' => 171,
                'height' => 136
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'cutting-3-complex',
                'form_id' => 57,
                'cutting_id' => 3,
                'width' => 118,
                'height' => 134
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => 'cutting-4-complex',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 118,
                'height' => 134
            ],
            [
                'calculator_id' => 3821,
                'svg_id' => '3814-3821-3821-4-preview',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 118,
                'height' => 134,
                'is_volume' => 1
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'cutting-2-round',
                'form_id' => 54,
                'cutting_id' => 2,
                'width' => 174,
                'height' => 153
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'cutting-4-complex',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 134,
                'height' => 152,
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => '3814-3819-3819-4-preview',
                'form_id' => 57,
                'cutting_id' => 4,
                'width' => 156,
                'height' => 152,
                'is_volume' => 1
            ],
            // cutting-3-round
            [
                'calculator_id' => 3819,
                'svg_id' => 'cutting-3-round',
                'form_id' => 54,
                'cutting_id' => 3,
                'width' => 132,
                'height' => 132
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'cutting-3-rect',
                'form_id' => 55,
                'cutting_id' => 3,
                'width' => 214,
                'height' => 137
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'cutting-3-oval',
                'form_id' => 56,
                'cutting_id' => 3,
                'width' => 171,
                'height' => 136
            ],
            [
                'calculator_id' => 3819,
                'svg_id' => 'cutting-3-complex',
                'form_id' => 57,
                'cutting_id' => 3,
                'width' => 118,
                'height' => 134
            ],
        ];

        foreach ($newPreviews as $preview) {
            $calculator = Calculator::query()->find($preview['calculator_id']);

            Preview::query()
                ->where('calculator_id', $calculator->id)
                ->where('calculator_type_id', $calculator->calculatorType?->id)
                ->where('form_id', $preview['form_id'])
                ->where('cutting_id', $preview['cutting_id'])
                ->where('is_volume', isset($preview['is_volume']))
                ->delete();

            Preview::query()->create([
                'calculator_id' => $calculator->id,
                'svg_id' => $preview['svg_id'],
                'calculator_type_id' => $calculator->calculatorType?->id,
                'form_id' => $preview['form_id'],
                'cutting_id' => $preview['cutting_id'],
                'width' => $preview['width'],
                'height' => $preview['height'],
                'is_volume' => isset($preview['is_volume'])
            ]);
        }

        $previews = [
            [
                'svg_id' => '3814-3815-3815-1-preview',
                'size' => [
                    'height' => 200,
                    'width' => 230
                ]
            ],
            [
                'svg_id' => '3814-3815-3815-2-preview',
                'size' => [
                    'height' => 152,
                    'width' => 174
                ]
            ],
            [
                'svg_id' => '3814-3815-3815-3-preview',
                'size' => [
                    'height' => 136,
                    'width' => 136
                ]
            ],
            [
                'svg_id' => '3814-3815-3815-4-preview',
                'size' => [
                    'height' => 152,
                    'width' => 152
                ]
            ],
            //
            [
                'svg_id' => '3814-3816-3816-1-preview',
                'size' => [
                    'width' => 270,
                    'height' => 200
                ]
            ],
            [
                'svg_id' => '3814-3816-3816-2-preview',
                'size' => [
                    'width' => 230,
                    'height' => 152
                ]
            ],
            [
                'svg_id' => '3814-3816-3816-3-preview',
                'size' => [
                    'width' => 214,
                    'height' => 136
                ]
            ],
            [
                'svg_id' => '3814-3816-3816-4-preview',
                'size' => [
                    'width' => 229,
                    'height' => 152
                ]
            ],
            //
            [
                'svg_id' => '3814-3827-3827-1-preview',
                'size' => [
                    'width' => 270,
                    'height' => 200
                ]
            ],
            [
                'svg_id' => '3814-3827-3827-2-preview',
                'size' => [
                    'width' => 210,
                    'height' => 152
                ]
            ],
            [
                'svg_id' => '3814-3827-3827-3-preview',
                'size' => [
                    'width' => 172,
                    'height' => 138
                ]
            ],
            [
                'svg_id' => '3814-3827-3827-4-preview',
                'size' => [
                    'width' => 188,
                    'height' => 151
                ]
            ],
            //
            [
                'svg_id' => '3814-3817-3817-1-preview',
                'size' => [
                    'width' => 184,
                    'height' => 200
                ]
            ],
            [
                'svg_id' => 'ill-figure-sticker-hand-cut',
                'size' => [
                    'width' => 173,
                    'height' => 152
                ]
            ],
            [
                'svg_id' => '3814-3817-3817-3-preview',
                'size' => [
                    'width' => 115,
                    'height' => 136
                ]
            ],
            [
                'svg_id' => '3814-3817-3817-4-preview',
                'size' => [
                    'width' => 134,
                    'height' => 152
                ]
            ],
            //
            [
                'svg_id' => '3814-3818-3818--preview',
                'size' => [
                    'width' => 203,
                    'height' => 200
                ]
            ],
            //
            [
                'svg_id' => '3814-3819-3819-1-preview',
                'size' => [
                    'width' => 213,
                    'height' => 192
                ]
            ],
            [
                'svg_id' => '3814-3819-3819-2-preview',
                'size' => [
                    'width' => 173,
                    'height' => 152
                ]
            ],
            [
                'svg_id' => '3814-3820-3820-1-preview',
                'size' => [
                    'width' => 206,
                    'height' => 200
                ]
            ],
            [
                'svg_id' => '3814-3820-3820-2-preview',
                'size' => [
                    'width' => 173,
                    'height' => 152
                ]
            ],
            [
                'svg_id' => '3814-3820-3820-5-preview',
                'size' => [
                    'width' => 214,
                    'height' => 136
                ]
            ],
            [
                'svg_id' => '3814-3826-3826-6-preview',
                'size' => [
                    'width' => 214,
                    'height' => 136
                ]
            ]
        ];

        foreach ($previews as $preview) {
            $previewModel = Preview::query()->where('svg_id', $preview['svg_id'])->first();

            $previewModel?->update($preview['size']);
        }

        $specPreviewCalculators = [3824, 3820, 3823, 3822];

        foreach ($specPreviewCalculators as $calculatorId) {
            $allCuttings = Cutting::all();
            $calculator = Calculator::query()->find($calculatorId);

            $allCuttings->each(fn (Cutting $cutting) => Preview::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_type_id' => $calculator->calculatorType->id,
                'is_mounting_film' => 1,
                'cutting_id' => $cutting->id,
                'svg_id' => 'spec-preview'
            ]));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
