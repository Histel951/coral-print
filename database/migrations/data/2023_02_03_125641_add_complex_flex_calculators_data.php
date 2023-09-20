<?php

use App\Models\CalcStandardList;
use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Color;
use App\Models\FlexMaterial;
use App\Models\FormField;
use App\Models\Material;
use App\Models\MaterialVarieties;
use App\Models\PrintForm;
use App\Models\RapportKnife;
use App\Models\WindingCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Collection;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $materialVarietiesTypes = [
            'Пленка' => 'film',
            'Бумага' => 'paper',
            'Термо' => 'termo',
            'Специальные' => 'special',
            'Рибон' => 'ribbon'
        ];

        foreach ($materialVarietiesTypes as $name => $type) {
            MaterialVarieties::query()->where('name', $name)->update([
                'type' => $type
            ]);
        }

        $calculatorType = CalculatorType::query()->where('name', 'labelsTag')->first();

        $calculatorOpacityFilmWithWhite = Calculator::query()->create([
            'name' => 'На прозрачной плёнке с белым',
            'description' => 'На прозрачной пенке с белым',
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'in-opaciti-film-with-white',
            'calculator_type_id' => $calculatorType->getKey(),
            'parameters' => [
                'is_knifes' => true,
            ],
            'print_form_id' => PrintForm::query()->where('name', 'Сложная')->first()->id,
        ]);

        $calculatorOpacityFilmWithWhite->fields()->create([
            'type' => 'fields',
            'value' => ["form", "width_height_flex", "product_count_types", "material_select", "color_paints", "location"]
        ]);

        $calculatorOpacityFilmWithWhite->forms()->sync(PrintForm::query()->whereIn('name', [
            'Круглая',
            'Прямоугольная',
            'Овальная',
            'Сложная'
        ])->pluck('id'));

        $calculatorOpacityFilmWithWhite->colors()->sync(
            Color::query()->whereIn('name', ['Белым цветом', 'Полноцвет+белым'])->pluck('id')
        );

        $calculatorPersonalisation = Calculator::query()->create([
            'name' => 'Этикетки с персонализацией',
            'description' => 'Этикетки с персонализацией',
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'personalized-labels',
            'calculator_type_id' => $calculatorType->getKey(),
            'parameters' => [
                'is_knifes' => true,
            ],
            'print_form_id' => PrintForm::query()->where('name', 'Прямоугольная')->first()->id,
        ]);

        $calculatorPersonalisation->colors()->sync(
            Color::all()->pluck('id')
        );

        $calculatorPersonalisation->forms()->sync(PrintForm::query()->whereIn('name', [
            'Круглая',
            'Прямоугольная',
            'Овальная',
            'Сложная'
        ])->pluck('id'));

        $calculatorTermo = Calculator::query()->create([
            'name' => 'Термоэтикетка',
            'description' => 'Термоэтикетка',
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'thermo-labels',
            'calculator_type_id' => $calculatorType->getKey(),
            'parameters' => [
                'is_knifes' => true,
            ],
            'print_form_id' => PrintForm::query()->where('name', 'Прямоугольная')->first()->id,
        ]);

        $calculatorTermo->forms()->sync(PrintForm::query()->whereIn('name', [
            'Прямоугольная'
        ])->pluck('id'));

        FormField::query()->create([
            'name' => 'rolls',
            'type' => 'input',
            'sequence' => 3,
            'parameters' => [
                'numbersOnly' => true,
                'label' => 'Рулоны',
                'default' => 300,
                'formField' => 'rolls',
                'tooltip_field_name' => 'Рулоны'
            ]
        ]);

        // product_count_types

        $calculatorTermo->colors()->sync(
            Color::all()->pluck('id')
        );

        $ribbonField = FormField::query()->create([
            'name' => 'ribbon',
            'type' => 'select',
            'parameters' => [
                'label' => 'Риббон',
                'formField' => 'ribbon'
            ]
        ]);

        FormField::query()->create([
            'name' => 'dummy',
            'type' => 'checkbox',
            'parameters' => [
                'info' => false,
                'label' => 'Пустышка',
                'checked' => false,
                'formField' => 'dummy',
                'tooltip_field_name' => 'Пустышка'
            ]
        ]);

        $calculatorTermo->checkboxes()->create([
            'value' => ['dummy']
        ]);

        $calculatorTermo->fields()->create([
            'type' => 'fields',
            'value' => ['form', 'width_height_flex', 'rolls', 'product_count_types', 'material_select', 'color_paints', 'location']
        ]);



        $calculatorTermo->materials()->sync($this->getMaterialByFlexMaterialIds([14, 15])->pluck('id'));

        $calculatorPersonalisation->fields()->create([
            'type' => 'fields',
            'value' => ["form", "width_height_flex", "product_count_types", "material_select", "color_paints", "location", $ribbonField->name]
        ]);

        $this->addWindingCategories([$calculatorOpacityFilmWithWhite, $calculatorPersonalisation, $calculatorTermo]);
        $this->addModelTextDataMessage($calculatorOpacityFilmWithWhite);
        $this->addModelTextDataMessage($calculatorPersonalisation);
        $this->addModelTextDataMessage($calculatorTermo);
    }

    /**
     * @param array<int> $ids
     * @return Collection<Material>
     */
    private function getMaterialByFlexMaterialIds(array $ids): Collection
    {
        $flexMaterials = FlexMaterial::query()->whereIn('id', $ids);

        return Material::query()->whereIn('name', $flexMaterials->pluck('name'))->get();
    }

    /**
     * @param Calculator[] $calculators
     * @return void
     */
    private function addWindingCategories(array $calculators): void
    {
        foreach ($calculators as $calculator) {
            $calculator->windingCategories()->sync(WindingCategory::all()->pluck('id'));
        }
    }

    private function getIdsByCoralList(int $listId): array
    {
        return explode(',', CalcStandardList::query()->find($listId)->ids);
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function addModelTextDataMessage(Calculator $calculator): void
    {
        $this->setTextField($calculator, [
            'postText' => ['R=#radius# мм', true],
            'name' => ['#width#x#height# мм', true],
            'postNameText' => [', углы ', false]
        ]);
    }

    /**
     * @param Calculator $calculator
     * @param array<string> $fields
     * @return void
     */
    private function setTextField(Calculator $calculator, array $fields): void
    {
        foreach ($fields as $fieldName => [$message, $isInt]) {
            $newModelTextData = $calculator->modelTextDataMessage()->create([
                'message' => $message,
                'model_class' => RapportKnife::class
            ]);

            $calculator->modelTextDataMessage()->updateExistingPivot($newModelTextData, [
                'model_field' => $fieldName,
                'is_int' => $isInt,
                'print_form_id' => $calculator->printForm?->id,
            ]);
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
