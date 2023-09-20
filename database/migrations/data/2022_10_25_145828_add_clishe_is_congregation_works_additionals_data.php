<?php

use App\Models\PivotWorkAdditional;
use App\Models\WorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $workAdditional = WorkAdditional::query()->where('code', '#конгревклишевиз')->first();

        PivotWorkAdditional::query()->create([
            'work_additional_id' => $workAdditional->id,
            'is_cliche' => true,
            'is_congregation' => true
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
