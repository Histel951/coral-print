<?php

use App\Models\Preview;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // svg_id => height px
        $previewHeight = [
            'visitki-rectangle-preview' => 136,
            'visitki-rounded-preview' => 167,
            'visitki-rectangle-rounded-preview' => 136,
            'visitki-complex-preview' => 167
        ];

        foreach ($previewHeight as $preview => $heightPx) {
            Preview::query()->where('svg_id', $preview)->update([
                'height' => $heightPx
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
