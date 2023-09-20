<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $extraMessage = "Максимальный размер #max_size#x#max_size# мм<br>Минимальный размер #min_size#x#min_size# мм";

        $calculatorMin40Max120 = Calculator::query()->whereIn('id', [3831, 3832, 3834, 3835]);

        $calculatorMax120 = Calculator::query()->whereIn('id', [3836, 3833]);

        $calculatorMin40Max120->each(fn (Calculator $calculator) => $this->setMinRestriction(
            $calculator,
            40,
            extraMaxSize: 120,
            message: $extraMessage
        ));

        $calculatorMax120->each(fn (Calculator $calculator) => $this->setMinRestriction(
            $calculator,
            1,
            extraMaxSize: 120,
            message: $extraMessage
        ));
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

    private function setMinRestriction(Calculator $calculator, int $minSize, $maxSize = 5000, int $extraMaxSize = 120, string $message = ''): void
    {
        $restriction = $calculator->restrictions()->create([
            'max_size' => $maxSize,
            'min_size' => $minSize,
            'extra_max_size' => $extraMaxSize
        ]);

        $restriction->messages()->create([
            'error_fields' => ['width_height', 'diameter'],
            'text' => $message,
            'is_print_restrict' => false,
            'is_extra' => true
        ]);
    }
};
