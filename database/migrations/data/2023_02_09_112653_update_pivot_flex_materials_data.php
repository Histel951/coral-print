<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\FlexMaterial;
use App\Models\Material;
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
        $calculators = CalculatorType::query()->where('name', 'labelsTag')
            ->first()->calculators;

        $calculators->whereIn('name', ['Серебрянные и золотистые этикетки'])->each(
            fn (Calculator $calculator) => $calculator->materials()->sync(
                $this->getMaterialByFlexMaterialIds($calculator->materials->pluck('id')->toArray())
                    ->pluck('id')->toArray()
            )
        );

        $silverGoldEticCalculator = $calculators->where('name', 'На прозрачной плёнке с белым')->first();
        $silverGoldEticCalculator->materials()->sync($this->getMaterialByFlexMaterialIds([8])->pluck('id'));

        $personalizationCalculator = $calculators->where('name', 'Этикетки с персонализацией')->first();
        $personalizationCalculator->materials()->sync($this->getMaterialByFlexMaterialIds([5, 6, 8, 14, 15])->pluck('id'));

        // Термоэтикетка
        $thermoCalculator = $calculators->where('name', 'Термоэтикетка')->first();
        $thermoCalculator->materials()->sync($this->getMaterialByFlexMaterialIds([14, 15])->pluck('id'));

        $this->showCalculatorMaterials($calculators->where('name', 'Серебрянные и золотистые этикетки')->first());
        $this->showCalculatorMaterials($silverGoldEticCalculator);
        $this->showCalculatorMaterials($thermoCalculator);
    }

    private function showCalculatorMaterials(Calculator $calculator): void
    {
        $calculator->materials()->each(fn (Material $material) => $material->update([
            'is_show' => true
        ]));
    }

    private function getMaterialByFlexMaterialIds(array $ids): Collection
    {
        $flexMaterials = FlexMaterial::query()->whereIn('id', $ids);

        return Material::query()->whereIn('name', $flexMaterials->pluck('name'))->get();
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
