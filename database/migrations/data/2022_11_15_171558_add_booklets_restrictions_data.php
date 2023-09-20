<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $messagePrint = "Макс. размер #print_max#x#print_min# мм<br>Мин. размер #min_size#x#min_size# мм";

        $calculators = CalculatorType::query()->where('name', 'booklets')->first()->calculators;

        $calculators->each(fn (Calculator $calculator) => $calculator->restrictions()->delete());
        $calculators->each(fn (Calculator $calculator) => $this->setMinRestriction($calculator, 100, $messagePrint));
    }

    private function setMinRestriction(Calculator $calculator, int $minSize, string $message = ''): void
    {
        $restriction = $calculator->restrictions()->create([
            'max_size' => 0,
            'min_size' => $minSize,
        ]);

        $restriction->messages()->create([
            'error_fields' => ['width_height', 'diameter'],
            'text' => $message,
            'is_print_restrict' => true,
            'is_extra' => false
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
