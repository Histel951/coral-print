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
        Schema::table('specie_types', function (Blueprint $table) {
            $table->unsignedInteger('min_height')->default(0);
            $table->unsignedInteger('min_width')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('specie_types', function (Blueprint $table) {
            $table->dropColumn('min_height', 'min_width');
        });
    }
};
