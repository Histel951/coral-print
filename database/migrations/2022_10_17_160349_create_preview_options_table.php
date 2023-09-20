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
        Schema::create('calculator_type_preview_options', function (Blueprint $table): void {
            $table->id();
            $table->enum('parameters_type', ['default', 'changeable'])->default('default');
            $table->timestamps();
        });

        Schema::table('calculator_types', function (Blueprint $table): void {
            $table->foreignId('calculator_type_preview_option_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('calculator_types', function (Blueprint $table): void {
            $table->dropColumn('calculator_type_preview_option_id')->nullable();
        });

        Schema::dropIfExists('calculator_type_preview_options');
    }
};
