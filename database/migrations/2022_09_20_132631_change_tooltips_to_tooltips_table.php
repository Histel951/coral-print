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
        Schema::table('tooltips', function (Blueprint $table) {
//            Schema::dropIfExists('pivot_tooltips');
            $table->dropColumn('description');
            $table->unsignedBigInteger('calculator_type_id')->after('content')->nullable();
            $table->unsignedBigInteger('field_id')->after('calculator_type_id')->nullable();
            $table->boolean('is_active')->nullable()->after('field_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tooltips', function (Blueprint $table) {
            //
        });
    }
};
