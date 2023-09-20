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
        Schema::table('color_counts', function (Blueprint $table) {
            $table->unsignedInteger('value')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('color_counts', function (Blueprint $table) {
            if (Schema::hasColumn('color_counts', 'value')) {
                $table->dropColumn('value');
            }
        });
    }
};
