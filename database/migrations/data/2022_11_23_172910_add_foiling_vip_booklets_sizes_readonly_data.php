<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\Foiling;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorFoiling;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $noFoilingOnlyPrint = Foiling::query()->where('name', 'Без фольги, только печать')->first();

        PivotCalculatorFoiling::query()->create([
            'calculator_id' => 3873,
            'foiling_id' => $noFoilingOnlyPrint->id
        ]);

        $newFile = new UploadedFile(public_path('images/foilings/no-color-spec-icon.svg'), 'no-color-spec-icon.svg');
        $noColorSpecIcon = (new File($newFile))->load();

        $noFoilingOnlyPrint->update([
            'spec_icon_id' => $noColorSpecIcon->getKey()
        ]);

        $foilingConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'foiling' => [
                    'disableds' => [
                        [
                            'type' => 'width_height',
                            'bigger' => 440,
                            'min' => 306,
                            'default' => 25
                        ]
                    ]
                ]
            ]
        ]);

        $varnishBackConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'varnish_back' => [
                    'disableds' => [
                        [
                            'type' => 'width_height',
                            'bigger' => 440,
                            'min' => 306,
                            'default' => 0
                        ]
                    ]
                ]
            ]
        ]);

        $varnishFaceConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'varnish_face' => [
                    'disableds' => [
                        [
                            'type' => 'width_height',
                            'bigger' => 440,
                            'min' => 306,
                            'default' => 0
                        ]
                    ]
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3873,
            'calculator_fields_config_id' => $varnishBackConfig->getKey()
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3873,
            'calculator_fields_config_id' => $varnishFaceConfig->getKey()
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3873,
            'calculator_fields_config_id' => $foilingConfig->getKey()
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
