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
        Schema::create('bolts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('count')->default(1);
            $table->timestamps();
        });

        Schema::table('pivot_work_additionals', function (Blueprint $table) {
            $table->foreignId('bolt_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('bolts');
        Schema::dropColumns('pivot_work_additionals', ['bolt_id']);
    }
};
