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
        if (Schema::hasTable('job_types')) {
            Schema::table('job_types', function ($table) {
                $table->double('weight', 20, 10)->default(0);
                $table->double('volume', 20, 10)->default(0);
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
        if (Schema::hasTable('job_types')) {
            Schema::table('job_types', function ($table) {
                $table->dropColumn('weight');
                $table->dropColumn('volume');
            });
        }
    }
};
