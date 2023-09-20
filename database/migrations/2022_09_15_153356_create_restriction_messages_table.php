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
    public function up(): void
    {
        Schema::create('print_restriction_messages', function (Blueprint $table) {
            $table->id();
            $table->string('error_field')->comment('Название подсвечивающегося поля');
            $table->text('message')->nullable()
                ->comment('Сообщение для пользователя в случае не прохождения проверки на граничения');
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
        Schema::dropIfExists('print_restriction_messages');
    }
};
