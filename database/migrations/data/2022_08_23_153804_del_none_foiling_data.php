<?php

use App\Models\FoilingColor;
use App\Models\PivotFoilingColor;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotFoilingColor::query()->where('foiling_color_id', 63);
        FoilingColor::query()->find(63)->delete();
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
