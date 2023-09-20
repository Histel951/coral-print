<?php

use App\Models\CustomConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        CustomConfig::query()->create([
            'name' => 'thermo_print',
            'value' => 3000
        ]);

        CustomConfig::query()->where('name', 'markup_bushing_price_percent')->first()->update([
            'name' => 'markup_bushing_price'
        ]);

        CustomConfig::query()->create([
            'name' => 'markup_bushing_price_percent',
            'value' => 0
        ]);

        CustomConfig::query()->create([
            'name' => 'min_price',
            'value' => 9950
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
