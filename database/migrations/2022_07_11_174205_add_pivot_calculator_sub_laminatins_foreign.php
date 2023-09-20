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
        Schema::table('pivot_calculator_laminations', function (Blueprint $table) {
            $table->foreignId('calculator_sub_id')->after('print_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivot_calculator_laminations', function (Blueprint $table) {
            $table->dropColumn('calculator_sub_id');
        });
    }
};
