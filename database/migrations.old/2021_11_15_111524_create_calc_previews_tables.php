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
        if (!Schema::hasTable('calc_previews')) {
            Schema::create('calc_previews', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('calc_category_id');
                $table->integer('calc_type_id')->default(0);
                $table->integer('calc_form_id')->default(0);
                $table->integer('calc_cutting_id')->default(0);
                $table->string('image')->nullable();
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
        Schema::dropIfExists('calc_previews');
    }
};
