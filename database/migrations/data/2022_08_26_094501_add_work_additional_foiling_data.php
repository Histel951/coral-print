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
        PivotWorkAdditional::query()->find(100)?->delete();
        PivotWorkAdditional::query()->find(351)?->delete();

        $data = [
            [
                'print_forms' => [54, 55, 56],
                'work_additional' => 44
            ],
            [
                'print_forms' => [57],
                'work_additional' => 45
            ],
        ];

        foreach ($data as $item) {
            foreach ($item['print_forms'] as $form) {
                PivotWorkAdditional::query()->create([
                    'calculator_id' => 3821,
                    'work_additional_id' => $item['work_additional'],
                    'is_volume' => 1,
                    'print_form_id' => $form
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
