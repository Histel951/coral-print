<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class () extends Migration {
    public function up()
    {
        DB::beginTransaction();
        try {
            DB::table('payment_types')->insert([
                'id' => 1,
                'name' => 'Оформление без оплаты',
            ]);
            DB::table('payment_types')->insert([
                'id' => 2,
                'name' => 'Оплатить как физическое лицо',
            ]);
            DB::table('payment_types')->insert([
                'id' => 3,
                'name' => 'Заказать счет для оплаты юридическим лицом',
            ]);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            Log::error($exception->getMessage(), ['trace' => $exception->getTrace()]);
        }
    }
};
