<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\Color;
use App\Models\ColorPaint;
use App\Models\ColorType;
use App\Models\FormField;
use App\Models\Material;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\WindingCategory;
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
        $this->setCalculatedCalculatorType();
        $this->setFormFields();
        $this->setWindings();

        $calculatorType = CalculatorType::query()->where('name', 'labelsTag')->first();

        $rectangularLabelsRoll = Calculator::query()->create([
            'name' => 'Прямоугольные этикетки в рулоне',
            'description' => 'Прямоугольные этикетки в рулоне',
            'calculator_type_id' => $calculatorType->id,
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'rect-labels-roll'
        ]);

        $ovalLabelsRoll = Calculator::query()->create([
            'name' => 'Овальные этикетки в рулоне',
            'description' => 'Прямоугольные этикетки в рулоне',
            'calculator_type_id' => $calculatorType->id,
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'oval-labels-roll'
        ]);

        $roundLabelsRoll = Calculator::query()->create([
            'name' => 'Круглые этикетки в рулоне',
            'description' => 'Круглые этикетки в рулоне',
            'calculator_type_id' => $calculatorType->id,
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'round-labels-roll'
        ]);

        $complexLabelsRoll = Calculator::query()->create([
            'name' => 'Фигурные этикетки в рулоне',
            'description' => 'Фигурные этикетки в рулоне',
            'calculator_type_id' => $calculatorType->id,
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'complex-labels-roll'
        ]);

        $allCalculators = [$rectangularLabelsRoll, $ovalLabelsRoll, $roundLabelsRoll, $complexLabelsRoll];

        $this->setCalculatorWindings();
        $this->setMaterials($allCalculators);
        $this->setColors($allCalculators);

        foreach ([$rectangularLabelsRoll, $ovalLabelsRoll, $complexLabelsRoll] as $calculator) {
            $this->setFields($calculator, ['width_height_flex', 'product_count_types', 'material_select', 'color_paints', 'location']);
        }

        $configNotRoundedSize = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'is_not_rounded' => true
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $configNotRoundedSize->getKey(),
            'calculator_id' => $ovalLabelsRoll->id,
        ]);

        $configKnifeType = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'is_knife_type' => true
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $configKnifeType->getKey(),
            'calculator_id' => $complexLabelsRoll->id,
        ]);

        $this->setFields($roundLabelsRoll, ['diameter', 'product_count_types', 'material_select', 'color_paints', 'location']);
    }

    private function setFields(Calculator $calculator, array $fields): void
    {
        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields',
            'value' => $fields
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $config->getKey()
        ]);
    }

    private function setCalculatorWindings(): void
    {
        $calculators = CalculatorType::query()->where('name', 'labelsTag')->first()->calculators;

        $calculators->each(
            fn (Calculator $calculator) => WindingCategory::all()->each(
                fn (WindingCategory $windingCategory) => $calculator->windingCategories()->attach($windingCategory->id)
            )
        );
    }

    private function setWindings(): void
    {
        $windingCategoryStraight = WindingCategory::query()->create([
            'name' => 'Пямая намотка',
            'sequence' => 1
        ]);

        $windingCategoryReverse = WindingCategory::query()->create([
            'name' => 'Обратная намотка',
            'sequence' => 2
        ]);

        $windings = [
            'straight' => [
                [
                    'image_id' => 'straight-1.svg',
                    'preview' => 'preview-straight-1.svg'
                ],
                [
                    'image_id' => 'straight-2.svg',
                    'preview' => 'preview-straight-2.svg'
                ],
                [
                    'image_id' => 'straight-3.svg',
                    'preview' => 'preview-straight-3.svg'
                ],
                [
                    'image_id' => 'straight-4.svg',
                    'preview' => 'preview-straight-4.svg'
                ],
            ],
            'reverse' => [
                [
                    'image_id' => 'reverse-1.svg',
                    'preview' => 'preview-reverse-1.svg'
                ],
                [
                    'image_id' => 'reverse-2.svg',
                    'preview' => 'preview-reverse-2.svg'
                ],
                [
                    'image_id' => 'reverse-3.svg',
                    'preview' => 'preview-reverse-3.svg'
                ],
                [
                    'image_id' => 'reverse-4.svg',
                    'preview' => 'preview-reverse-4.svg'
                ]
            ]
        ];

        foreach ($windings['straight'] as $winding) {
            $image = new UploadedFile(public_path("/images/winding/{$winding['image_id']}"), $winding['image_id']);
            $imageAttachment = (new File($image))->load();

            $preview = new UploadedFile(public_path("/images/winding/{$winding['preview']}"), $winding['preview']);
            $previewAttachment = (new File($preview))->load();

            $windingCategoryStraight->windings()->create([
                'image_id' => $imageAttachment->getKey(),
                'preview_id' => $previewAttachment->getKey()
            ]);
        }

        foreach ($windings['reverse'] as $winding) {
            $image = new UploadedFile(public_path("/images/winding/{$winding['image_id']}"), $winding['image_id']);
            $imageAttachment = (new File($image))->load();

            $preview = new UploadedFile(public_path("/images/winding/{$winding['preview']}"), $winding['preview']);
            $previewAttachment = (new File($preview))->load();

            $windingCategoryReverse->windings()->create([
                'image_id' => $imageAttachment->getKey(),
                'preview_id' => $previewAttachment->getKey()
            ]);
        }
    }

    private function setFormFields(): void
    {
        FormField::query()->create([
            'parameters' => [
                'label' => 'Размер',
                'formField' => 'knife',
                'postNameIcon' => 'degree'
            ],
            'name' => 'width_height_flex',
            'type' => 'select'
        ]);

        FormField::query()->create([
            'parameters' => [
                'label' => 'Цветность',
                'formColorField' => 'color',
                'formPaintField' => 'paint',
                'formField' => 'color_paints'
            ],
            'name' => 'color_paints',
            'type' => 'select-material-many-additional'
        ]);

        FormField::query()->create([
            'parameters' => [
                'label' => 'Расположение',
                'label_title' => 'Выбор тип намотки с ориентацией этикетки',
                'formField' => 'location',
            ],
            'name' => 'location',
            'type' => 'select-horizontal-modal'
        ]);

        FormField::query()->create([
            'parameters' => [
                'label' => 'Расположение',
                'label_title' => 'Выбор тип намотки с ориентацией этикетки',
                'formField' => 'location',
            ],
            'name' => 'location',
            'type' => 'select-horizontal-modal'
        ]);

        FormField::query()->create([
            'parameters' => [
                'label' => 'Материал',
                'formField' => 'material',
            ],
            'name' => 'material_select',
            'type' => 'select-category'
        ]);
    }

    private function setCalculatedCalculatorType(): void
    {
        $stickersLabelTagCalculators = CalculatorType::query()->where('name', 'labelsTag')
            ->first()->calculators;

        $stickersCalculatorType = CalculatorType::query()->where('name', 'stickers')->first();

        $stickersLabelTagCalculators->each(
            fn (Calculator $calculator) => $calculator->update([
                'calculated_calculator_type_id' => $stickersCalculatorType->id
            ])
        );
    }

    /**
     * @param Calculator[] $calculators
     * @return void
     */
    private function setMaterials(array $calculators): void
    {
        $coralFlexMaterials = Material::query()->whereNotNull('article');
        $allMaterialIds = $coralFlexMaterials->get()->pluck('id');

        foreach ($calculators as $calculator) {
            $calculator->materials()->sync($allMaterialIds);
        }
    }

    /**
     * @param Calculator[] $calculators
     * @return void
     */
    private function setColors(array $calculators): void
    {
        $flexColorType = ColorType::query()->create([
            'name' => 'flex'
        ]);

        $flexColors = Color::query()->whereIn('name', [
            'Цветной (C,M,Y,K)',
            'Только белый (W)',
            'Цветной с белым (C,M,Y,K+W)',
            'Black (K)',
            'Выбрать вручную'
        ]);

        $flexColors->each(fn (Color $color) => $color->update([
            'color_type_id' => $flexColorType->getKey()
        ]));

        $paintImages = [
            'Cian (C)' => 'cian.svg',
            'Magenta (M)' => 'magenta.svg',
            'Yellow (Y)' => 'yellow.svg',
            'Black (K)' => 'black.svg',
            'Белый (W)' => 'white.svg',
            'Пантон' => 'panton.svg',
            'Матовый лак' => 'mate-varnish.svg',
            'Глянцевый лак' => 'glossy-varnish.svg'
        ];

        foreach ($paintImages as $paintName => $paintImage) {
            $file = new UploadedFile(public_path("/images/paints/{$paintImage}"), $paintImage);
            $attachment = (new File($file))->load();

            $color = ColorPaint::query()->where('name', $paintName)->first();

            $color->update([
                'image_id' => $attachment->getKey()
            ]);
        }

        foreach ($calculators as $calculator) {
            $flexColors->each(
                fn (Color $color) => $calculator->colors()->attach($color->id)
            );
        }
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
