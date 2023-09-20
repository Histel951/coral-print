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
        Schema::table('calculator_model_text_data_message', function (Blueprint $table) {
            $table->boolean('is_use_post_text_icon')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('calculator_model_text_data_message', function (Blueprint $table) {
            if (Schema::hasColumn('calculator_model_text_data_message', 'is_use_post_text_icon')) {
                $table->dropColumn('is_use_post_text_icon');
            }
        });
    }
};
