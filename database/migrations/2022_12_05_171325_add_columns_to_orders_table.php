<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->foreignId('payment_type_id')->nullable()->constrained('payment_types');
            $table->foreignId('delivery_type_id')->nullable()->constrained('delivery_types');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('file_upload_id')->nullable()->constrained('file_uploads');
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->decimal('price');
            $table->decimal('delivery_price');
            $table->unsignedTinyInteger('discount')->default(0);
            $table->uuid('order_uuid')->index();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('payment_type_id');
            $table->dropConstrainedForeignId('delivery_type_id');
            $table->dropConstrainedForeignId('department_id');
            $table->dropConstrainedForeignId('file_upload_id');
            $table->dropConstrainedForeignId('company_id');
            $table->dropColumn([
                'phone',
                'price',
                'delivery_price',
                'discount',
                'order_uuid',
            ]);
        });
    }
};
