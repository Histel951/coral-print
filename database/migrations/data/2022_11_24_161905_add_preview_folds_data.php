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
        $previews = [
            [
                'svg_id' => ['booklets-books-preview', 'booklets-books-down-preview'],
                'folds' => 1
            ],
            [
                'svg_id' => ['booklets-books-2-folds-preview', 'booklets-books-2-folds-down-preview'],
                'folds' => 2
            ],
            [
                'svg_id' => ['booklets-accordion-3-folds-preview', 'booklets-accordion-3-folds-down-preview'],
                'folds' => 3
            ],
            [
                'svg_id' => ['booklets-vip-4-folds-preview', 'booklets-vip-4-folds-down-preview'],
                'folds' => 4
            ],
            [
                'svg_id' => ['booklets-vip-5-folds-preview', 'booklets-vip-5-folds-down-preview'],
                'folds' => 5
            ]
        ];

        foreach ($previews as $preview) {
            foreach ($preview['svg_id'] as $svgId) {
                $previewModel = Preview::query()->where('svg_id', $svgId)->where('calculator_id', 3873)->first();

                $previewModel->update([
                    'folds' => $preview['folds']
                ]);
            }
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
