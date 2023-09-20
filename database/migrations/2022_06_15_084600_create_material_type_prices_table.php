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
        // todo пока не нужно
//        Schema::create('material_type_prices', function (Blueprint $table) {
//            $table->id();
//            $table->double('cost_price', 8, 2, true)->default(0.00);
//            $table->double('extra_change', 8, 2, true)->default(0.00);
//            $table->double('price', 8, 2, true)->default(0.00);
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_type_prices');
    }
};
