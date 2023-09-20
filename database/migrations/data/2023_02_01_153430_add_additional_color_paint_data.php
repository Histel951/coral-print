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
        $color = \App\Models\Color::query()->where('name', 'Полноцвет+белым')->first();
        $paint = $color->paints()->where('name', 'Белый (W)')->first();
        $paint->colors()->updateExistingPivot($color->id, [
            'is_additional_paint' => true
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
