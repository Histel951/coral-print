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
        Schema::table('calculators', function (Blueprint $table): void {
            $table->string('svg_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('calculators', function (Blueprint $table) {
            if (Schema::hasColumn('calculators', 'svg_id')) {
                $table->dropColumn('svg_id');
            }
        });
    }
};
