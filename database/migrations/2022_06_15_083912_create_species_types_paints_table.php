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
        Schema::create('specie_type_paints', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity')->default(0);
            $table->double('paint1', 8, 2, true)->default(0.00);
            $table->double('paint2', 8, 2, true)->default(0.00);
            $table->double('paint3', 8, 2, true)->default(0.00);
            $table->double('paint4', 8, 2, true)->default(0.00);
            $table->double('paint5', 8, 2, true)->default(0.00);
            $table->double('paint6', 8, 2, true)->default(0.00);
            $table->double('paint7', 8, 2, true)->default(0.00);
            $table->double('paint8', 8, 2, true)->default(0.00);
            $table->unsignedInteger('overprice');
            $table->foreignId('specie_type_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specie_type_paints');
    }
};
