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
        if (Schema::hasTable('site_content') and !Schema::hasColumns('site_content', ['created_at', 'updated_at'])) {
            Schema::table('site_content', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable('site_content') and Schema::hasColumns('site_content', ['created_at', 'updated_at'])) {
            Schema::table('site_content', function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }
};
