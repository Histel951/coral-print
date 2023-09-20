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
        if (Schema::hasTable('flex_paints')) {
            Schema::table('flex_paints', function ($table) {
                $table->string('image');
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
        if (Schema::hasTable('flex_paints')) {
            Schema::table('flex_paints', function ($table) {
                $table->dropColumn('image');
            });
        }
    }
};
