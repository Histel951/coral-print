<?php

use App\Models\FlexMaterial;
use App\Models\Material;
use App\Models\MaterialVarieties;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $film = MaterialVarieties::query()->create([
            'name' => 'Пленка'
        ]);

        $paper = MaterialVarieties::query()->create([
            'name' => 'Бумага'
        ]);

        $termo = MaterialVarieties::query()->create([
            'name' => 'Термо'
        ]);

        $special = MaterialVarieties::query()->create([
            'name' => 'Специальные'
        ]);

        $ribbon = MaterialVarieties::query()->create([
            'name' => 'Рибон'
        ]);

        FlexMaterial::query()->each(function (FlexMaterial $flexMaterial) use ($film, $ribbon, $special, $paper, $termo) {
            $material = Material::query()->where('name', $flexMaterial->name)->first();

            $varielties = match ($flexMaterial->type) {
                1 => $film,
                2 => $paper,
                3 => $termo,
                4 => $special,
                5 => $ribbon
            };

            $material?->update([
                'material_variety_id' => $varielties->getKey()
            ]);
        });
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
