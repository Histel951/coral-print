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
        Schema::table('previews', function (Blueprint $table) {
            $table->boolean('is_rotate')->default(false);
            $table->boolean('is_split')->default(false);
            $table->unsignedInteger('transition_x')->default(0);
            $table->unsignedInteger('transition_y')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('previews', function (Blueprint $table) {
//            $table->dropColumn('is_split', 'transition_x', 'transition_y');
        });
    }
};
