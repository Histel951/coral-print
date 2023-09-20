<?php

use App\Models\CalculatorRestrictionMessage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allRestrictionMessages = CalculatorRestrictionMessage::all();
        $allRestrictionMessages->each(function (CalculatorRestrictionMessage $message): void {
            $text = $message->text;

            $text = Str::replace('Максимальный', 'Макс.', $text);
            $text = Str::replace('Минимальный', 'Мин.', $text);

            $message->update([
                'text' => $text
            ]);
        });
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
