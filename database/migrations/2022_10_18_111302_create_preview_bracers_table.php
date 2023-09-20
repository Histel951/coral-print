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
        Schema::create('preview_bracers', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        Schema::table('previews', function (Blueprint $table): void {
            if (!Schema::hasColumn('previews', 'preview_bracer_id')) {
                $table->foreignId('preview_bracer_id')->nullable();
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
        Schema::dropIfExists('preview_bracers');

        Schema::table('previews', function (Blueprint $table): void {
            if (Schema::hasColumn('previews', 'preview_bracer_id')) {
                $table->dropColumn('preview_bracer_id');
            }
        });
    }
};
