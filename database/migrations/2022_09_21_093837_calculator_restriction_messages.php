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
        Schema::create('calculator_restriction_messages', function (Blueprint $table) {
            $table->id();
            $table->json('error_fields');
            $table->text('text');
            $table->foreignId('calculator_restriction_id')->nullable();
            $table->boolean('is_print_restrict')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('calculator_restriction_messages');
    }
};
