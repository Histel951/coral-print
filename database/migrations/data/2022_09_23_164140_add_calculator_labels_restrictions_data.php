<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $messagePrint = "Максимальный размер #print_width#x#print_height# мм<br>Минимальный размер #min_size#x#min_size# мм";

        $calculatorsMin50 = Calculator::query()->whereIn('name', [
            'Круглые воблеры',
            'Воблеры сложной формы',
            'Круглые бирки',
            'Бирки сложной формы'
        ]);

        $calculatorsMin10 = Calculator::query()->whereIn('name', [
            'Простые воблеры',
            'Хенгеры',
            'Простые бирки'
        ]);

        $calculatorsMin50->each(function (Calculator $calculator) use ($messagePrint): void {
            $this->setRestriction($calculator, 50, $messagePrint);
        });

        $calculatorsMin10->each(function (Calculator $calculator) use ($messagePrint): void {
            $this->setRestriction($calculator, 10, $messagePrint);
        });
    }

    private function setRestriction(Calculator $calculator, int $minSize, string $message): void
    {
        $restriction = $calculator->restrictions()->create([
            'max_size' => 0,
            'min_size' => $minSize
        ]);

        $restriction->messages()->create([
            'error_fields' => ['width_height', 'diameter'],
            'text' => $message,
            'is_print_restrict' => true
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
