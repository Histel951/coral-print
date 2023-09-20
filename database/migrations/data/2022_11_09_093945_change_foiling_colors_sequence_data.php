<?php

use App\Models\Foiling;
use App\Models\FoilingColor;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $foilingSequence = [
            25 => 1,
            26 => 2,
            27 => 3
        ];

        foreach ($foilingSequence as $foiling => $sequence) {
            Foiling::query()->find($foiling)->update([
                'sequence' => $sequence
            ]);
        }

        $foilingColorSequence = [
            64 => 2,
            65 => 3,
            66 => 4,
            67 => 5,
            68 => 6,
            69 => 7,
            70 => 8,
            71 => 9,
            72 => 10,
            88 => 1
        ];

        foreach ($foilingColorSequence as $color => $sequence) {
            FoilingColor::query()->find($color)->update([
                'sequence' => $sequence
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
