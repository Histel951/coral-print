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
        Schema::table('calculators', function (Blueprint $table) {
            $table->unsignedInteger('width_without_print')->default(1200);
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
            $table->dropColumn('width_without_print');
        });
    }
};
