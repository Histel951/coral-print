<?php

use App\Models\ColorCount;
use App\Models\PivotCalculatorColorCount;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private int $i = 20;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        ColorCount::query()->each(function (ColorCount $colorCount) {
            PivotCalculatorColorCount::query()->where('color_count_id', $colorCount->id)
                ->update([
                    'color_count_id' => $this->i
                ]);

            $colorCount->update([
                'id' => $this->i,
                'value' => --$colorCount->id
            ]);

            $this->i += 1;
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
