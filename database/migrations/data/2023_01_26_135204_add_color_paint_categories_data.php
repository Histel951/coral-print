<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $colorPaintCategory = \App\Models\ColorPaintCategory::query()->create([
            'name' => 'Флекса',
            'type' => 'flex'
        ]);

        $colorPaints = \App\Models\ColorPaint::query()->whereIn('name', [
            'Cian (C)',
            'Magenta (M)',
            'Yellow (Y)',
            'Black (K)',
            'Белый (W)',
            'Пантон',
            'Серебряная краска',
            'Золотая краска',
            'Матовый лак',
            'Глянцевый лак'
        ]);

        $colorPaints->each(fn (\App\Models\ColorPaint $paint) => $paint->category()->attach($colorPaintCategory->id));
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
