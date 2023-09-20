<?php

use App\Models\FormField;
use App\Models\PivotCalculatorBlockSelectFields;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $configs = [26, 27];
        foreach ($configs as $formField) {
            $config = FormField::query()->find($formField);
            $config->update([
                'parameters' => Arr::collapse([
                    $config->parameters,
                    [
                        'isSelectField' => true
                    ]
                ])
            ]);
        }

        $coverMaterialFormField = FormField::query()->find(25);
        $newCoverMaterialFormField = FormField::query()->create([
            'name' => 'material_cover',
            'type' => 'material',
            'parameters' => Arr::collapse([$coverMaterialFormField->parameters, [
                'isSelectField' => true
            ]])
        ]);

        PivotCalculatorBlockSelectFields::query()->find(18)->update([
            'form_field_id' => $newCoverMaterialFormField->getKey()
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
