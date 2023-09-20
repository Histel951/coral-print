<?php

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
        Preview::query()->where('svg_id', 'cutting-3-complex')->update([
            'height' => 138
        ]);

        Preview::query()->where('svg_id', 'cutting-4-complex')->update([
            'height' => 156
        ]);

        Preview::query()->where('svg_id', 'ill-figure-sticker-hand-cut')->update([
            'height' => 180
        ]);
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
