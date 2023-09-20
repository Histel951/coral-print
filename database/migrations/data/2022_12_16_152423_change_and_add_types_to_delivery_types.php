<?php

use App\Models\DeliveryType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        $moscowCourier = DeliveryType::find(1);
        $moscowCourier->name = 'Доставка курьером по Москве';
        $moscowCourier->save();

        DeliveryType::create([
            'name' => 'Доставка курьером за МКАД',
        ]);
    }
};
