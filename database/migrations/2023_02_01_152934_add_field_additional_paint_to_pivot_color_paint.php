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
        Schema::table('pivot_color_paint', function (Blueprint $table) {
            $table->boolean('is_additional_paint')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivot_color_paint', function (Blueprint $table) {
            $table->dropColumn('is_additional_paint');
        });
    }
};
