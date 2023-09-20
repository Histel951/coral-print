<?php

use App\Models\Preview;
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
        $allHeightPreviews = Preview::query()->where('sequence', 1)->where('is_changeable', 1);
        $allWidthPreviews = Preview::query()->where('sequence', 2);

        $allHeightPreviews->update([
            'dependence' => 'common'
        ]);

        $allWidthPreviews->update([
            'dependence' => 'reversal'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $allHeightPreviews = Preview::query()->where('dependence', 'common');
        $allWidthPreviews = Preview::query()->where('dependence', 'reversal');

        DB::table('previews')->update([
            'dependence' => null
        ]);

        $allHeightPreviews->update([
            'dependence' => 'height'
        ]);

        $allWidthPreviews->update([
            'dependence' => 'width'
        ]);
    }
};
