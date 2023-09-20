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
        if (Schema::hasTable('offset_size')) {
            Schema::table('offset_size', function (Blueprint $table) {
                $table->string('color')->nullable();
                $table->string('lam')->nullable();
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
        if (Schema::hasTable('offset_size')) {
            Schema::table('offset_size', function ($table) {
                $table->dropColumn('color');
                $table->dropColumn('lam');
            });
        }
    }
};
