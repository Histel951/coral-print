<?php

use App\Models\SpecieType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $specieTypes = [30, 36, 37];

        foreach ($specieTypes as $specieTypeId) {
            $oldSpecieType = SpecieType::query()->find($specieTypeId);

            $oldSpecieType->update([
                'height' => $oldSpecieType->width,
                'width' => $oldSpecieType->height
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $specieTypes = [30, 36, 37];

        foreach ($specieTypes as $specieTypeId) {
            $oldSpecieType = SpecieType::query()->find($specieTypeId);

            $oldSpecieType?->update([
                'height' => $oldSpecieType->width,
                'width' => $oldSpecieType->height
            ]);
        }
    }
};
