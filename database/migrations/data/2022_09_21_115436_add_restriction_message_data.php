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

        $messageNoPrint = "Максимальный размер #print_bigger#x#max_size# мм<br>Минимальный размер #min_size#x#min_size# мм";

        $extraMessage = "Максимальный размер #max_size#x#max_size# мм<br>Минимальный размер #min_size#x#min_size# мм";

        $calculatorsCatalog = Calculator::query()->where('calculator_type_id', 3854);

        $calculatorsCatalog->each(
            function (Calculator $calculator) use ($messagePrint): void {
                $restriction = $calculator->restrictions()->create([
                    'max_size' => 0,
                    'min_size' => 100
                ]);

                $restriction->messages()->create([
                    'error_fields' => ['width_height', 'diameter'],
                    'text' => $messagePrint,
                    'is_print_restrict' => true
                ]);
            }
        );

        $messages = [
            [
                'text' => $messagePrint,
                'is_print_restrict' => true
            ],
            [
                'text' => $messageNoPrint,
                'is_print_restrict' => false
            ]
        ];

        $this->setCalculatorsMessage([3826, 3818], $messages, 50);
        $this->setCalculatorsMessage([3824, 3822, 3820, 3823], $messages, 10);

        $this->setCalculatorsMessage(
            Calculator::query()
                ->whereNotIn('id', [3824, 3822, 3820, 3823, 3826, 3818, 3829, 3821, 3819])
                ->where('calculator_type_id', 3814)
                ->pluck('id')
                ->toArray(),
            $messages,
            5
        );


        $this->setCalculatorsMessage([3829, 3819, 3821], $messages, 5, 60, [
            [
                'text' => $extraMessage,
                'is_print_restrict' => false
            ]
        ]);
    }

    private function setCalculatorsMessage(array $calculatorIds, array $messages, int $min, int $extraMax = null, array $extraMessages = []): void
    {
        $calculators = Calculator::query()->whereIn('id', $calculatorIds);

        $calculators->each(
            function (Calculator $calculator) use ($min, $messages, $extraMax, $extraMessages): void {
                $restriction = $calculator->restrictions()->create([
                    'max_size' => 5000,
                    'min_size' => $min,
                    'extra_max_size' => $extraMax
                ]);

                foreach ($messages as $message) {
                    $restriction->messages()->create([
                        'error_fields' => ['width_height', 'diameter'],
                        'text' => $message['text'],
                        'is_print_restrict' => $message['is_print_restrict']
                    ]);
                }

                foreach ($extraMessages as $message) {
                    $restriction->messages()->create([
                        'error_fields' => ['width_height', 'diameter'],
                        'text' => $message['text'],
                        'is_print_restrict' => $message['is_print_restrict'],
                        'is_extra' => true
                    ]);
                }
            }
        );
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
