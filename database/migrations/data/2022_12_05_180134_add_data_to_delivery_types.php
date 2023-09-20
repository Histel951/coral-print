<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class () extends Migration {
    public function up()
    {
        DB::beginTransaction();
        try {
            DB::table('delivery_types')->insert([
                'id' => 1,
                'name' => 'Доставка курьером',
            ]);
            DB::table('delivery_types')->insert([
                'id' => 2,
                'name' => 'Самовывоз',
            ]);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            Log::error($exception->getMessage(), ['trace' => $exception->getTrace()]);
        }
    }
};
