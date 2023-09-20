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
        Schema::table('pivot_work_additionals', function (Blueprint $table) {
            $table->foreignId('material_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivot_work_additionals', function (Blueprint $table) {
            if (Schema::hasColumn('pivot_work_additionals', 'material_id')) {
                $table->dropColumn('material_id');
            }
        });
    }
};
