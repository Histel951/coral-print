<?php

use App\Models\PivotWorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotWorkAdditional::query()->where('work_additional_id', 82)
            ->whereIn('calculator_id', [3833, 3836])->update([
                'is_grid' => true
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
