<?php

use App\Models\FlexMaterial;
use App\Models\Material;
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
        $withRibbons = Ribbon::query()->whereIn('name', ['Wax Balck', 'Resign Black']);
        $noRibbon = Ribbon::query()->where('name', 'Без риббона')->first();

        $withRibbonsFlexMaterials = FlexMaterial::query()->whereIn('id', [5, 6, 8]);
        $noRibbonsFlexMaterials = FlexMaterial::query()->whereIn('id', [14, 15]);

        $withRibbonsFlexMaterials->each(function (FlexMaterial $flexMaterial) use ($withRibbons) {
            $material = Material::query()->where('name', $flexMaterial->name)->first();
            $withRibbons->each(fn (Ribbon $ribbon) => $ribbon->materials()->attach($material->id));
        });

        $noRibbonsFlexMaterials->each(function (FlexMaterial $flexMaterial) use ($noRibbon) {
            $material = Material::query()->where('name', $flexMaterial->name)->first();
            $noRibbon->materials()->attach($material->id);
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
