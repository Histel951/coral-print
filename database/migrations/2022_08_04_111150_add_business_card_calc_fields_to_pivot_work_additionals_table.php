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
            $table->boolean('is_rounding_corners')->nullable();
            $table->boolean('is_congregation')->nullable();
            $table->boolean('is_cliche')->nullable();
            $table->boolean('is_thermal_rise_face')->nullable();
            $table->boolean('is_thermal_rise_back')->nullable();
            $table->boolean('is_varnish_face')->nullable();
            $table->boolean('is_varnish_back')->nullable();
            $table->boolean('foiling_face')->nullable();
            $table->boolean('foiling_back')->nullable();
            $table->boolean('embossing_face')->nullable();
            $table->boolean('embossing_back')->nullable();
            $table->boolean('embossing_face2')->nullable();
            $table->boolean('embossing_back2')->nullable();
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
            $table->dropColumn('is_rounding_corners');
            $table->dropColumn('is_congregation');
            $table->dropColumn('is_cliche');
            $table->dropColumn('is_thermal_rise_face');
            $table->dropColumn('is_thermal_rise_back');
            $table->dropColumn('is_varnish_face');
            $table->dropColumn('is_varnish_back');
            $table->dropColumn('foiling_face');
            $table->dropColumn('foiling_back');
            $table->dropColumn('embossing_face');
            $table->dropColumn('embossing_back');
            $table->dropColumn('embossing_face2');
            $table->dropColumn('embossing_back2');
        });
    }
};
