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
                $table->string('image_small');
                $table->integer('not_available')->default(0);
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
                $table->dropColumn('image_small');
                $table->dropColumn('not_available');
            });
        }
    }
};
