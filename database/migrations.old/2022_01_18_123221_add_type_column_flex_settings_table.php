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
    public function up()
    {
        if (Schema::hasTable('module_print_settings')) {
            Schema::table('module_print_settings', function (Blueprint $table) {
                $table->string('type');
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
        if (Schema::hasTable('module_print_settings')) {
            Schema::table('module_print_settings', function ($table) {
                $table->dropColumn('type');
            });
        }
    }
};
