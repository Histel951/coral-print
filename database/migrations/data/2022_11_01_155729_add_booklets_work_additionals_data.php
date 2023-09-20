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
        PivotWorkAdditional::query()->where('calculator_id', 3873)
            ->where('work_additional_id', 18)->delete();

        PivotWorkAdditional::query()->where('calculator_id', 3873)
            ->where('work_additional_id', 68)->delete();

        PivotWorkAdditional::query()->create([
            'work_additional_id' => 18,
            'is_folds' => true,
            'calculator_id' => 3873
        ]);

        PivotWorkAdditional::query()->create([
            'work_additional_id' => 68,
            'is_folds' => true,
            'calculator_id' => 3873
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
