<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('previews', function (Blueprint $table) {
            $table->boolean('is_rounding_corners')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('previews', function (Blueprint $table) {
            if (Schema::hasColumn('previews', 'is_rounding_corners')) {
                $table->dropColumn('is_rounding_corners');
            }
        });
    }
};
