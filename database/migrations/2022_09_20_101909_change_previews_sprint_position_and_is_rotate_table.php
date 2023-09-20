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
            if (Schema::hasColumn('previews', 'is_rotate')) {
                $table->dropColumn('is_rotate');
            }

            if (!Schema::hasColumn('previews', 'rotate_sprint_position_id')) {
                $table->unsignedBigInteger('rotate_sprint_position_id')->nullable();
            }

            $table->foreign('rotate_sprint_position_id')->on('sprint_positions')->references('id');
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
//           $table->dropConstrainedForeignId('rotate_sprint_position_id');
        });
    }
};
