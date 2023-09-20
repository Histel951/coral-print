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
        Schema::table('foilings', function (Blueprint $table) {
            $table->unsignedBigInteger('spec_icon_id')->nullable();
            $table->foreign('spec_icon_id')->on('files')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('foilings', function (Blueprint $table) {
            if (Schema::hasColumn('foiling_colors', 'spec_icon_id')) {
                $table->dropForeign(['spec_icon_id']);
                $table->dropColumn('spec_icon_id');
            }
        });
    }
};
