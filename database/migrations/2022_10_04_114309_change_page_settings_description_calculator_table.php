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
        if (Schema::hasTable('calculator_type_pages')) {
            Schema::rename('calculator_type_pages', 'calculator_pages');
        }

        Schema::table('calculator_types', function (Blueprint $table) {
            if (Schema::hasColumn('calculator_types', 'calculator_type_page_id')) {
                $table->dropColumn('calculator_type_page_id');
//                $table->dropForeign(['calculator_type_page_id']);
            }
        });

        Schema::table('calculators', function (Blueprint $table) {
            $table->foreignId('calculator_page_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::rename('calculator_pages', 'calculator_type_pages');

        Schema::table('calculator_types', function (Blueprint $table) {
            $table->foreignId('calculator_type_page_id');
        });

        Schema::dropIfExists('calculator_type_pages');
    }
};
