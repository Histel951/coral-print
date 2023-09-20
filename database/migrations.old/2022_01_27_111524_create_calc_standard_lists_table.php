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
        if (!Schema::hasTable('calc_standard_lists')) {
            Schema::create('calc_standard_lists', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('ids');
                $table->string('alias')->nullable();
                $table->integer('calc_fields_id')->nullable();
                $table->integer('calc_category_id');
                $table->timestamps();
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
        Schema::dropIfExists('calc_standard_lists');
    }
};
