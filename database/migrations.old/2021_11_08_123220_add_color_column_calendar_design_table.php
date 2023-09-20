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
        if (Schema::hasTable('calendar_design')) {
            Schema::table('calendar_design', function (Blueprint $table) {
                $table->string('color')->nullable();
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
        if (Schema::hasTable('calendar_design')) {
            Schema::table('calendar_design', function ($table) {
                $table->dropColumn('color');
            });
        }
    }
};
