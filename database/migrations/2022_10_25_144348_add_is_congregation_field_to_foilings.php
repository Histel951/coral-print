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
        Schema::table('foilings', function (Blueprint $table) {
            $table->boolean('is_none')->default(false);
            $table->boolean('is_congregation')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('foilings', function (Blueprint $table) {
            if (Schema::hasColumn('foilings', 'is_congregation')) {
                $table->dropColumn('is_congregation');
            }

            if (Schema::hasColumn('foilings', 'is_none')) {
                $table->dropColumn('is_none');
            }
        });
    }
};
