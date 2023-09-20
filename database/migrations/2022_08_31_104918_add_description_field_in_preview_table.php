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
            $table->string('description')->nullable();

            // ------------------------------------------------
            // будет ли меняться размер картинки при отображении
            // в зависимости от проставленной ширины и высоты
            // ------------------------------------------------
            $table->boolean('is_changeable')->default(false);
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
//            $table->dropColumn('description', 'is_changeable');
        });
    }
};
