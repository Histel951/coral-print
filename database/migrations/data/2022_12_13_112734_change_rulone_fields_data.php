<?php

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $flexMaterialCategories = [
            1 => 'Пленка',
            2 => 'Бумага',
            3 => 'Термо',
            4 => 'Специальные',
            5 => 'Рибон'
        ];

        foreach ($flexMaterialCategories as $flexTypeMaterialCategory => $materialCategoryName) {
            $materialCategory = MaterialCategory::query()->where('name', $materialCategoryName)->first();

            if (!$materialCategory) {
                $flexMaterialCategories[$flexTypeMaterialCategory] = MaterialCategory::query()->create([
                    'name' => $materialCategoryName
                ]);
            } else {
                $flexMaterialCategories[$flexTypeMaterialCategory] = $materialCategory;
            }
        }

        $coralFlexMaterials = DB::select('select * from coral_flex_materials');

        foreach ($coralFlexMaterials as $flexMaterial) {
            $flexMaterialCategories[$flexMaterial->type]->materials()->save(
                Material::query()->where('article', $flexMaterial->article)->first()
            );
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
