<?php

use App\Models\PrintForm;
use App\Models\RapportKnife;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // 83 - круг
        // 82 - прямоугольник
        // 84 - овал
        // 85 - сложная
        // 86 - особая

        $specialPrintForm = PrintForm::query()->create([
            'name' => 'Особая'
        ]);

        RapportKnife::all()->each(function (RapportKnife $rapportKnife) use ($specialPrintForm) {
            if ($rapportKnife->print_form_id === 82) {
                $rapportKnife->print_form_id = 55;
            }

            if ($rapportKnife->print_form_id === 83) {
                $rapportKnife->print_form_id = 54;
            }

            if ($rapportKnife->print_form_id === 84) {
                $rapportKnife->print_form_id = 56;
            }

            if ($rapportKnife->print_form_id === 85) {
                $rapportKnife->print_form_id = 57;
            }

            if ($rapportKnife->print_form_id === 86) {
                $rapportKnife->print_form_id = $specialPrintForm->getKey();
            }

            $rapportKnife->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
