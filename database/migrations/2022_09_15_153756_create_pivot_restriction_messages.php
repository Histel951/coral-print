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
        Schema::create('pivot_print_restriction_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('print_restriction_message_id')->nullable();
            $table->foreignId('print_restriction_id')->nullable();
            $table->foreignId('specie_type_id')->nullable();
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
        Schema::dropIfExists('pivot_print_restriction_messages');
    }
};
