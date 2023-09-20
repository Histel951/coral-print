<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $foilingWorksAdditionals = [
            26 => [77, 78],
            27 => [77, 79]
        ];

        foreach ($foilingWorksAdditionals as $foilingId => $worksAdditionals) {
            foreach ($worksAdditionals as $workAdditionalId) {
                \App\Models\PivotWorkAdditional::query()->create([
                    'foiling_id' => $foilingId,
                    'work_additional_id' => $workAdditionalId,
                    'calculator_sub_id' => 1
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
