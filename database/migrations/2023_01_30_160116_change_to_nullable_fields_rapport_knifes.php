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
        Schema::table('rapport_knifes', function (Blueprint $table) {
            $table->foreignId('print_form_id')->nullable()->change();
            $table->double('width', 8, 2)->nullable()->change();
            $table->double('height', 8, 2)->nullable()->change();
            $table->unsignedInteger('count_rapport')->nullable()->change();
            $table->unsignedInteger('count_rows')->nullable()->change();
            $table->double('line_space', 8, 2)->nullable()->change();
            $table->unsignedInteger('print_height')->nullable()->change();
            $table->unsignedInteger('price')->nullable()->change();
            $table->unsignedInteger('price_percent')->nullable()->change();
            $table->string('marking')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('rapport_knifes', function (Blueprint $table) {
            $table->foreignId('print_form_id')->change();
            $table->double('width', 8, 2)->change();
            $table->double('height', 8, 2)->change();
            $table->unsignedInteger('count_rapport')->change();
            $table->unsignedInteger('count_rows')->change();
            $table->double('line_space', 8, 2)->change();
            $table->unsignedInteger('print_height')->change();
            $table->unsignedInteger('price')->change();
            $table->unsignedInteger('price_percent')->change();
            $table->string('marking')->change();
        });
    }
};
