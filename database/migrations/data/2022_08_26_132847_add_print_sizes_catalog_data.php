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
        PrintSize::query()->where('calculator_type_id', 3854)->delete();

        $data = [
            [
                'name' => 'А6 книга',
                'short_name' => '105x148',
                'width' => 105,
                'height' => 148,
                'calculators' => [3855, 3856, 3859, 3860]
            ],
            [
                'name' => 'А6 альбом',
                'short_name' => '148x105',
                'width' => 148,
                'height' => 105,
                'calculators' => [3855, 3856, 3859, 3860]
            ],
            [
                'name' => 'А5 книга',
                'short_name' => '148x210',
                'width' => 148,
                'height' => 210,
                'calculators' => [3855, 3856, 3859, 3860, 3866]
            ],
            [
                'name' => 'А5 альбом',
                'short_name' => '210x148',
                'width' => 210,
                'height' => 148,
                'calculators' => [3855, 3856, 3859, 3860, 3866]
            ],
            [
                'name' => 'А4 книга',
                'short_name' => '210x297',
                'width' => 210,
                'height' => 297,
                'calculators' => [3855, 3856, 3858, 3859, 3860, 3866]
            ],
            [
                'name' => 'А4 альбом',
                'short_name' => '297x210',
                'width' => 297,
                'height' => 210,
                'calculators' => [3856, 3858, 3859, 3866]
            ],
            [
                'name' => 'А3 книга',
                'short_name' => '297x420',
                'width' => 297,
                'height' => 420,
                'calculators' => [3856, 3858]
            ],
            [
                'name' => 'А3 альбом',
                'short_name' => '420x297',
                'width' => 420,
                'height' => 297,
                'calculators' => [3856, 3858]
            ],
        ];

        foreach ($data as $item) {
            $printSize = PrintSize::query()->create([
                'name' => $item['name'],
                'short_name' => $item['short_name'],
                'width' => $item['width'],
                'height' => $item['height']
            ]);

            foreach ($item['calculators'] as $calculatorId) {
                PivotCalculatorPrintSize::query()->create([
                    'calculator_id' => $calculatorId,
                    'print_size_id' => $printSize->getKey()
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
