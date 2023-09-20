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
            $table->boolean('is_paints')->default(false);
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
            if (Schema::hasColumn('specie_types', 'is_paints')) {
                $table->dropColumn('is_paints');
            }
        });
    }
};
