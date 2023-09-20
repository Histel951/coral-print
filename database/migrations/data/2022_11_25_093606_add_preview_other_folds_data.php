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
        $previewFolds = [
            [
                'svg_id' => 'booklets-books-down-preview',
                'folds' => 1
            ],
            [
                'svg_id' => 'booklets-books-2-folds-down-preview',
                'folds' => 2
            ],
            [
                'svg_id' => 'booklets-accordion-2-folds-down-preview',
                'folds' => 2
            ],
            [
                'svg_id' => 'booklets-accordion-3-folds-down-preview',
                'folds' => 3
            ],
            [
                'svg_id' => 'booklets-snails-3-folds-down-preview',
                'folds' => 3
            ],
        ];

        foreach ($previewFolds as $preview) {
            $previewModel = Preview::query()->where('svg_id', $preview['svg_id'])->whereNull('folds');

            $previewModel->update([
                'folds' => $preview['folds']
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
        //
    }
};
