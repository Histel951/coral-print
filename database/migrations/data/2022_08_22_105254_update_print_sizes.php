<?php

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
        PrintSize::all()->each(function (PrintSize $printSize): void {
            [$height, $width] = explode('x', $printSize->short_name);

            if ($printSize->id != 54 and $printSize->id != 55) {
                PrintSize::find($printSize->id)->update([
                    'short_name' => "{$height}x{$width}",
                    'width' => $height,
                    'height' => $width
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
        PrintSize::all()->each(function (PrintSize $printSize): void {
            [$height, $width] = explode('x', $printSize->short_name);

            if ($printSize->id != 54 or $printSize->id != 55) {
                $printSize->update([
                    'short_name' => "{$width}x{$height}",
                    'width' => $height,
                    'height' => $width
                ]);
            }
        });
    }
};
