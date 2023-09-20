<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->string('name');
            $table->unsignedSmallInteger('count');
            $table->unsignedInteger('product_count');
            $table->decimal('product_price');
            $table->decimal('design_price');
            $table->decimal('item_price');
            $table->decimal('total_price');
            $table->json('design_services');
            $table->json('client_designs')->nullable();
            $table->text('design_comment')->nullable();
            $table->unsignedDouble('weight');
            $table->json('props');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
