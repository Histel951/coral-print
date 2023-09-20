<?php

use App\Models\ColorPaint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $pantoneColorPaints = [
            ColorPaint::query()->where('name', 'Серебряная краска')->first(),
            ColorPaint::query()->where('name', 'Золотая краска')->first()
        ];

        foreach ($pantoneColorPaints as $paint) {
            $paint->update([
                'is_pantone' => true
            ]);
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
