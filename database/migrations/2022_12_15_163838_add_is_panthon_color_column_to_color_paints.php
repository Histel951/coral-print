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
        Schema::table('color_paints', function (Blueprint $table) {
            $table->boolean('is_pantone')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('color_paints', function (Blueprint $table) {
            if (Schema::hasColumn('color_paints', 'is_pantone')) {
                $table->dropColumn('is_pantone');
            }
        });
    }
};
