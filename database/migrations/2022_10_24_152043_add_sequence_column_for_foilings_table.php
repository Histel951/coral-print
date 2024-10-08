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
            $table->unsignedInteger('sequence')->default(1);
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
            if (Schema::hasColumn('foilings', 'sequence')) {
                $table->dropColumn('sequence');
            }
        });
    }
};
