<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Preview;
use App\Models\PreviewPrintSizePixel;
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
        $allCatalogCalculators = CalculatorType::query()->where('name', 'catalogs')
            ->first()->calculators;

        $printSizes = [
           [
               'name' => 'А3 альбом',
               'short_name' => '420x297',
               'pixel_w' => 148,
               'pixel_h' => 104
           ],
           [
               'name' => 'А3 книга',
               'short_name' => '297x420',
               'pixel_w' => 74,
               'pixel_h' => 104
           ],
           [
               'name' => 'А4 альбом',
               'short_name' => '297x210',
               'pixel_w' => 136,
               'pixel_h' => 95
           ],
           [
               'name' => 'А4 книга',
               'short_name' => '210x297',
               'pixel_w' => 68,
               'pixel_h' => 95
           ],
           [
               'name' => 'А5 альбом',
               'short_name' => '210x148',
               'pixel_w' => 122,
               'pixel_h' => 85
           ],
           [
               'name' => 'А5 книга',
               'short_name' => '148x210',
               'pixel_w' => 61,
               'pixel_h' => 85
           ],
           [
               'name' => 'А6 альбом',
               'short_name' => '148x105',
               'pixel_w' => 110,
               'pixel_h' => 76
           ],
           [
               'name' => 'А6 книга',
               'short_name' => '105x148',
               'pixel_w' => 55,
               'pixel_h' => 76
           ]
        ];

        foreach ($printSizes as $size) {
            $printSize = PrintSize::query()->where('name', $size['name'])
                ->where('short_name', $size['short_name'])->first();

            $allCatalogCalculators->each(function (Calculator $calculator) use ($size, $printSize): void {
                $previews = $calculator->previews();

                $previews->each(fn (Preview $preview) => PreviewPrintSizePixel::query()->create([
                    'preview_id' => $preview->id,
                    'print_size_id' => $printSize->id,
                    'pixels_w' => $size['pixel_w'],
                    'pixels_h' => $size['pixel_h']
                ]));
            });
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
