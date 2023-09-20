<?php

use App\Models\Color;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $colors = [
            'Цветной (C,M,Y,K)' => [10,11,12,13],
            'Только белый (W)' => [14],
            'Цветной с белым (C,M,Y,K+W)' => [10,11,13,12,14],
            'Black (K)' => [13],
            'Выбрать вручную' => []
        ];

        foreach ($colors as $colorName => $syncPaints) {
            Color::query()->where('name', $colorName)->first()->paints()->sync($syncPaints);
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
