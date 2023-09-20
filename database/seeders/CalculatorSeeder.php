<?php

namespace Database\Seeders;

use App\Models\Calculator;
use App\Models\CalculatorType;
use Illuminate\Database\Seeder;

class CalculatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalculatorType::factory(10)->create();
        Calculator::factory(20)->create();
    }
}
