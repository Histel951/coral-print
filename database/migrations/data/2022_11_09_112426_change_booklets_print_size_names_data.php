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
        PrintSize::query()->find(43)->update([
            'name' => 'A3 (420x297 мм)'
        ]);

        PrintSize::query()->find(68)->update([
            'name' => 'A7 (74x105 мм)'
        ]);

        PrintSize::query()->find(69)->update([
            'name' => 'A6 (105x148 мм)'
        ]);

        PrintSize::query()->find(70)->update([
            'name' => 'A5 (148x210 мм)'
        ]);

        PrintSize::query()->find(70)->update([
            'name' => 'A4 (210x297 мм)'
        ]);

        PrintSize::query()->find(55)->update([
            'name' => 'Евро (98x210 мм)'
        ]);
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
