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
            $table->unsignedInteger('template_height_percent')->default(100)
                ->comment('Высота превью в шаблоне при отображении в процентах');

            $table->unsignedInteger('template_height_merger_percent')->default(0)
                ->comment('Процент слияния картинки и обложки картинки');

            $table->boolean('is_bracing_as_image_part')->default(false)
                ->comment('является ли крепёжная часть частью изделия (влияет на бордеры, бэкграунд)');
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
//            $table->dropColumn('template_height_percent', 'template_height_merger_percent', 'is_bracing_as_image_part');
        });
    }
};
