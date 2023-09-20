<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('rapport_knives')) {
            Schema::table('rapport_knives', function ($table) {
                $table->string('knife_number_summary');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('rapport_knives')) {
            Schema::table('rapport_knives', function ($table) {
                $table->dropColumn('knife_number_summary');
            });
        }
    }
};
