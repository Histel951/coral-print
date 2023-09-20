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
        if (Schema::hasTable('flex_materials')) {
            Schema::table('flex_materials', function (Blueprint $table) {
                $table->float('volume')->default(0);
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
        if (Schema::hasTable('flex_materials')) {
            Schema::table('flex_materials', function ($table) {
                $table->dropColumn('volume');
            });
        }
    }
};
