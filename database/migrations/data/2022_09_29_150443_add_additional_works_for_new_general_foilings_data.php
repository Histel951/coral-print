<?php

use App\Models\PivotWorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // foilingId => workId
        $foilingWorks = [
            26 => [77, 78],
            27 => [77, 79]
        ];

        foreach ($foilingWorks as $foilingId => $works) {
            foreach ($works as $workId) {
                PivotWorkAdditional::query()->create([
                    'foiling_id' => $foilingId,
                    'work_additional_id' => $workId
                ]);
            }
        }
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
