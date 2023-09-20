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
            $table->dropColumn('is_diameter');
            $table->json('parameters')->nullable();
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
            $table->boolean('is_diameter')->default(false);
//            $table->dropColumn('parameters');
        });
    }
};
