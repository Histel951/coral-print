<?php

use App\Models\Color;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Color::query()->find(12)->update([
            'is_two_side' => 0
        ]);

        Color::query()->find(13)->update([
            'is_two_side' => 1
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
