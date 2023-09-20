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
        Schema::table('form_fields_sequences', function (Blueprint $table): void {
            $table->dropColumn('calculator_type_id');
            $table->foreignId('calculator_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('form_fields_sequences', function (Blueprint $table): void {
            $table->dropColumn('calculator_id');
            $table->foreignId('calculator_type_id')->nullable();
        });
    }
};
