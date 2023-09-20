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
        if (Schema::hasTable('calendar_size')) {
            Schema::table('calendar_size', function ($table) {
                $table->dropColumn('weight');
                $table->dropColumn('volume');
            });
        }

        if (Schema::hasTable('calendar_size_type')) {
            Schema::table('calendar_size_type', function ($table) {
                $table->string('weight');
                $table->string('volume');
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
        if (Schema::hasTable('calendar_size')) {
            Schema::table('calendar_size', function ($table) {
                $table->float('weight', 10)->default(0);
                $table->float('volume', 10)->default(0);
            });
        }

        if (Schema::hasTable('calendar_size_type')) {
            Schema::table('calendar_size_type', function ($table) {
                $table->dropColumn('weight');
                $table->dropColumn('volume');
            });
        }
    }
};
