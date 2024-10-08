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
        if (Schema::hasTable('rapports')) {
            Schema::table('rapports', function ($table) {
                $table->integer('counter')->default(0);
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
        if (Schema::hasTable('rapports')) {
            Schema::table('rapports', function ($table) {
                $table->dropColumn('counter');
            });
        }
    }
};
