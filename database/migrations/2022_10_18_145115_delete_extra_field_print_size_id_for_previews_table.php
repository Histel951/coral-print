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
        Schema::table('previews', function (Blueprint $table): void {
            if (Schema::hasColumn('previews', 'print_size_id')) {
                $table->dropColumn('print_size_id');
            }

            if (Schema::hasColumn('previews', 'is_changeable')) {
//                $table->dropColumn('is_changeable');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('previews', function (Blueprint $table): void {
            if (!Schema::hasColumn('previews', 'print_size_id')) {
                $table->foreignId('print_size_id');
            }

            if (!Schema::hasColumn('previews', 'is_changeable')) {
                $table->boolean('is_changeable')->nullable();
            }
        });
    }
};
