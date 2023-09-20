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
        Schema::create('calculator_type_pages', function (Blueprint $table) {
            $table->id();
            $table->text('print_time_description')->nullable();
            $table->boolean('is_show_constructor')->default(false);
            $table->timestamps();
        });

        Schema::table('calculator_types', function (Blueprint $table) {
            $table->foreignId('calculator_type_page_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('calculator_type_pages');

        if (Schema::hasColumn('calculator_types', 'calculator_type_page_id')) {
            Schema::dropColumns('calculator_types', ['calculator_type_page_id']);
        }
    }
};
