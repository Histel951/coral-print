<?php

use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $changeFieldNames = [
            'embossing_face1_select' => [
                'info' => false,
                'label' => 'Тиснение 1',
                "dataField" => "embossing_face1_select",
                "formField" => "embossing_face1_select",
                'formColorField' => 'embossing_face1_select_color',
                'formMaterialField' => 'embossing_face1_select_visitki_vip_face_select',
                'labelModalLink' => 'embossing_face1_select-modal'
            ],
            'embossing_face2_select' => [
                'info' => false,
                'label' => 'Тиснение 2',
                "dataField" => "embossing_face2_select",
                "formField" => "embossing_face2_select",
                'formColorField' => 'embossing_face2_select_color',
                'formMaterialField' => 'embossing_face2_select_visitki_vip_face_select',
                'labelModalLink' => 'embossing_face2_select-modal'
            ],
            'embossing_back1_select' => [
                'info' => false,
                'label' => 'Тиснение 1',
                "dataField" => "embossing_back1_select",
                "formField" => "embossing_back1_select",
                'formColorField' => 'embossing_back1_select_color',
                'formMaterialField' => 'embossing_back1_select_visitki_vip_back_select',
                'labelModalLink' => 'embossing_back1_select-modal'
            ],
            'embossing_back2_select' => [
                'info' => false,
                'label' => 'Тиснение 2',
                "dataField" => "embossing_back2_select",
                "formField" => "embossing_back2_select",
                'formColorField' => 'embossing_back2_select_color',
                'formMaterialField' => 'embossing_back2_select_visitki_vip_back_select',
                'labelModalLink' => 'embossing_back2_select-modal'
            ],
        ];

        foreach ($changeFieldNames as $fieldName => $parameters) {
            FormField::query()->create([
                'name' => $fieldName,
                'type' => 'radio-material',
                'parameters' => $parameters
            ]);
        }
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
