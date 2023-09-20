<?php

use App\Models\Calculator;
use App\Models\Color;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $newColor = Color::query()->create([
            'name' => 'Без печати',
            'is_empty' => true
        ]);

        $calculator = Calculator::query()->where('name', 'Термоэтикетка')->first();
        $calculator->colors()->attach($newColor->getKey());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
