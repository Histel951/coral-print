<?php

use App\Models\FlexColor;
use App\Models\FlexColorPaint;
use App\Models\FlexMaterial;
use App\Services\CustomConfigs;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class () extends Migration {
    /**
     * Конфиги для подсчёта флексы
     * @var CustomConfigs|mixed
     */
    private CustomConfigs $customConfigs;

    public function __construct()
    {
        $this->customConfigs = app()->make(CustomConfigs::class);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $coralFlexMaterials = DB::select('select * from coral_flex_materials');
        $coralFlexColors = DB::select('select * from coral_flex_colors');
        $coralFlexPaints = DB::select('select * from coral_flex_paints');

        foreach ($coralFlexMaterials as $flexMaterial) {
            $flexMaterial = (array)$flexMaterial;

            FlexMaterial::query()->create([
                'name' => $flexMaterial['name'],
                'type' => $flexMaterial['type'],
                'article' => $flexMaterial['article'],
                'min_meters' => (int)$flexMaterial['min_meters'] ?? null,
                'weight' => $flexMaterial['weight'],
                'price' => (float)Str::replace(',', '.', $flexMaterial['price']),
                'price_percent' => (int)$flexMaterial['price_percent'],
                'show' => (bool)$flexMaterial['show'],
                'sequence' => (int)$flexMaterial['sequence'],
                'volume' => (int)$flexMaterial['volume']
            ]);
        }

        foreach ($coralFlexColors as $flexColor) {
            FlexColor::query()->create([
                'name' => $flexColor->name
            ]);
        }

        foreach ($coralFlexPaints as $flexPaint) {
            FlexColorPaint::query()->create([
                'name' => $flexPaint->name,
                'consumption' => (float)$flexPaint->consumption,
                'price' => (float)$flexPaint->price,
                'price_percent' => (int)$flexPaint->price_percent
            ]);
        }

        $configs = [
            'euro_rate' => 65,
            'fitting_meters' => 70,
            'min_fitting_meters_price' => 1500,
            'min_order_price' => 1500,
            'pantone_displacement' => 1,
            'fix_euro_price' => 0.30,
            'form_markup_percent' => 20,
            'bushing_price' => 0.06,
            'markup_bushing_price_percent' => 0.06,
            'thermo_adjustment_cost' => 0.06,
            'thermo_adjustment_price' => 0.06
        ];

        foreach ($configs as $configName => $value) {
            $this->customConfigs->set($configName, $value);
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
