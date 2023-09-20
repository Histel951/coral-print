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
        if (Schema::hasTable('offset_price')) {
            Schema::table('offset_price', function ($table) {
                $table->float('weight', 10);
                $table->float('volume', 10);
            });
        }

        if (Schema::hasTable('calendar_lam_price')) {
            Schema::table('calendar_lam_price', function ($table) {
                $table->float('weight');
                $table->float('volume');
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
        if (Schema::hasTable('offset_price')) {
            Schema::table('offset_price', function ($table) {
                $table->dropColumn('weight');
                $table->dropColumn('volume');
            });
        }

        if (Schema::hasTable('calendar_lam_price')) {
            Schema::table('calendar_lam_price', function ($table) {
                $table->dropColumn('weight');
                $table->dropColumn('volume');
            });
        }
    }
};
