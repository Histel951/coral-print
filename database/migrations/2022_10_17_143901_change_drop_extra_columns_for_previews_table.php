<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('previews', function (Blueprint $table): void {
//            $table->dropColumn('is_split');

            DB::statement("ALTER TABLE
                                    `previews`
                                MODIFY COLUMN
                                    `dependence` enum(
                                        'common',
                                        'reversal',
                                        'width',
                                        'height'
                                    )
                                NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('previews', function (Blueprint $table): void {
//            DB::statement("ALTER TABLE
//                                    `previews`
//                                MODIFY COLUMN
//                                    `dependence` enum(
//                                        'height',
//                                        'width'
//                                    )
//                                NULL");
        });
    }
};
