<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $businessCardType = CalculatorType::query()->where('name', 'businessCards')->first()->calculators;

        $vipVisitky = $businessCardType->where('name', 'VIP')->first();
        $plasticVisitky = $businessCardType->where('name', 'На прозрачном пластике')->first();

        $this->detachExtraConfigs([$vipVisitky, $plasticVisitky]);

        $vipVisitky->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'hideTypes' => true
                ]
            ]
        ]);

        $vipVisitky->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'isNotActions' => true
                ]
            ]
        ]);

        $vipVisitky->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'predefinedValues' => true
                ]
            ]
        ]);

        $plasticVisitky->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'hideTypes' => true
                ]
            ]
        ]);
    }

    /**
     * @param Calculator[] $calculators
     * @return void
     */
    private function detachExtraConfigs(array $calculators): void
    {
        foreach ($calculators as $calculator) {
            $isMultipleConfig = $calculator->fields()->whereJsonContains('value', [
                'product_count_types' => [
                    'isMultiple' => true
                ]
            ])->first();

            if ($isMultipleConfig) {
                $calculator->fields()->detach($isMultipleConfig->id);
            }
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
