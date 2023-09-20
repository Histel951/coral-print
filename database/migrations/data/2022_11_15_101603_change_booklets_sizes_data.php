<?php

use App\Models\Calculator;
use App\Models\PivotCalculatorPrintSize;
use App\Models\PrintSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $a7l = PrintSize::query()->create([
            'name' => 'А7 (74х105 мм)',
            'short_name' => '74х105',
            'height' => 105,
            'width' => 74
        ]);

        $a6l = PrintSize::query()->create([
            'name' => 'А6 (105х210 мм)',
            'short_name' => '105х210',
            'height' => 210,
            'width' => 105
        ]);

        $a5l = PrintSize::query()->create([
            'name' => 'А5 (148х210 мм)',
            'short_name' => '148х210',
            'height' => 210,
            'width' => 148
        ]);

        $a4l = PrintSize::query()->create([
            'name' => 'А4 (210х297 мм)',
            'short_name' => '210х297',
            'height' => 297,
            'width' => 210
        ]);

        $a3l = PrintSize::query()->create([
            'name' => 'А3 (420х297 мм)',
            'short_name' => '420х297',
            'height' => 297,
            'width' => 420
        ]);

        $euro = PrintSize::query()->create([
            'name' => 'Евро (98х210 мм)',
            'short_name' => '98х210',
            'height' => 210,
            'width' => 98
        ]);

        $a5b = PrintSize::query()->create([
            'name' => 'А5 (210х148 мм)',
            'short_name' => '210х148',
            'height' => 148,
            'width' => 210
        ]);

        $a4b = PrintSize::query()->create([
            'name' => 'А4 (297х210 мм)',
            'short_name' => '297х210',
            'height' => 210,
            'width' => 297
        ]);

        $a3b = PrintSize::query()->create([
            'name' => 'А3 (420х297 мм)',
            'short_name' => '420х297',
            'height' => 297,
            'width' => 420
        ]);

        $s630x210 = PrintSize::query()->create([
            'name' => '630х210 мм',
            'short_name' => '630х210',
            'height' => 210,
            'width' => 630
        ]);

        $s630x297 = PrintSize::query()->create([
            'name' => '630х297 мм',
            'short_name' => '630х297',
            'height' => 297,
            'width' => 630
        ]);

        $s400x210 = PrintSize::query()->create([
            'name' => '400х210 мм',
            'short_name' => '400х210',
            'height' => 210,
            'width' => 400
        ]);

        $s840x297 = PrintSize::query()->create([
            'name' => '840х297 мм',
            'short_name' => '840х297',
            'height' => 297,
            'width' => 840
        ]);

        $this->newPrintSizes(Calculator::query()->find(3867), [$a7l, $a6l, $a5l, $a4l, $a3l, $euro]);
        $this->newPrintSizes(Calculator::query()->find(3868), [$a5b, $a4b, $a3b]);
        $this->newPrintSizes(Calculator::query()->find(3869), [$a4b, $a3b, $s630x210, $s630x297]);
        $this->newPrintSizes(Calculator::query()->find(3870), [$a4b, $a3b, $s630x210, $s630x297]);
        $this->newPrintSizes(Calculator::query()->find(3871), [$s400x210, $s630x297, $s840x297]);
        $this->newPrintSizes(Calculator::query()->find(3872), [$s400x210, $s630x297, $s840x297]);
    }

    /**
     * @param Calculator|Model $calculator
     * @param PrintSize[] $printSizes
     * @return void
     */
    private function newPrintSizes(Calculator|Model $calculator, array $printSizes): void
    {
        $calculator->printSizes()->delete();

        foreach ($printSizes as $printSize) {
            PivotCalculatorPrintSize::query()->create([
                'calculator_id' => $calculator->id,
                'print_size_id' => $printSize->getKey()
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
