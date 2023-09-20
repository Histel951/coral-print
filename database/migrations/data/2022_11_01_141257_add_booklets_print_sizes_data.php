<?php

use App\Models\PivotCalculatorPrintSize;
use App\Models\PrintSize;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $a7 = PrintSize::query()->create([
            'name' => 'A7 (74x105)',
            'short_name' => '74x105',
            'height' => 105,
            'width' => 74
        ]);

        $a6 = PrintSize::query()->create([
            'name' => 'A6 (105x148)',
            'short_name' => '105x148',
            'height' => 148,
            'width' => 105,
        ]);

        $a5 = PrintSize::query()->create([
            'name' => 'A5 (148x210)',
            'short_name' => '148x210',
            'height' => 210,
            'width' => 148,
        ]);

        $a4 = PrintSize::query()->create([
            'name' => 'A4 (210x297)',
            'short_name' => '210x297',
            'height' => 297,
            'width' => 210,
        ]);

        $calculatorPrintsSizes = [
            3867 => [$a7->getKey(), $a6->getKey(), $a5->getKey(), $a4->getKey(), 43, 55],
            3868 => [$a5->getKey(), $a4->getKey(), 43],
            3869 => [$a4->getKey(), 43]
        ];

        foreach ($calculatorPrintsSizes as $calculatorId => $printsSize) {
            foreach ($printsSize as $printSize) {
                PivotCalculatorPrintSize::query()->create([
                    'calculator_id' => $calculatorId,
                    'print_size_id' => $printSize
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
