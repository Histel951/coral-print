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
        Schema::table('foiling_colors', function (Blueprint $table) {
            if (!Schema::hasColumn('foiling_colors', 'sequence')) {
                $table->unsignedInteger('sequence')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('foiling_colors', function (Blueprint $table) {
            if (Schema::hasColumn('foiling_colors', 'sequence')) {
                $table->dropColumn('sequence');
            }
        });
    }
};
