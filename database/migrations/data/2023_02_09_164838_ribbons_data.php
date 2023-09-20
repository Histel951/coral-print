<?php

use App\Models\Material;
use App\Models\MaterialVarieties;
use App\Models\Ribbon;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $ribbonMaterials = MaterialVarieties::query()->where('type', 'ribbon')->first()->materials;

        $ribbonMaterials->each(function (Material $material) {
            Ribbon::query()->create([
                'name' => $material->name,
                'material_id' => $material->id
            ]);
        });

        Ribbon::query()->first()->update([
            'name' => 'Wax Black'
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
