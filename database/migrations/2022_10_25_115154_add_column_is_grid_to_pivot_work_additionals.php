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
        Schema::table('pivot_work_additionals', function (Blueprint $table) {
            $table->boolean('is_grid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pivot_work_additionals', function (Blueprint $table) {
            if (Schema::hasColumn('pivot_work_additionals', 'is_grid')) {
                $table->dropColumn('is_grid');
            }
        });
    }
};
