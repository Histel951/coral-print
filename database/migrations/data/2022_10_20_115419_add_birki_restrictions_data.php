<?php

use App\Models\Calculator;
use App\Models\CalculatorRestriction;
use Illuminate\Database\Eloquent\Builder;
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

        $this->deleteFullRestrictions($calculatorsMin50);
        $this->deleteFullRestrictions($calculatorsMin10);

        $calculatorsMin50->each(fn (Calculator $calculator) => $this->setMinRestriction($calculator, 50, $messagePrint));
        $calculatorsMin10->each(fn (Calculator $calculator) => $this->setMinRestriction($calculator, 10, $messagePrint));
    }

    /**
     * @param Builder $calculators
     * @return void
     */
    private function deleteFullRestrictions(Builder $calculators): void
    {
        $calculators->each(function (Calculator $calculator) {
            $calculator->restrictions()->each(
                fn (CalculatorRestriction $restriction) => $restriction->messages()->delete()
            );
        });

        $calculators->each(function (Calculator $calculator) {
            $calculator->restrictions()->delete();
        });
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
