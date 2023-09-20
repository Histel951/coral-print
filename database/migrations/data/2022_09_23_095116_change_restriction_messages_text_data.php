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
        $allMessages = CalculatorRestrictionMessage::query();

        $allMessages->each(function (CalculatorRestrictionMessage $message): void {
            $text = $message->text;
            $text = Str::replace('#print_height#', '#print_min#', $text);
            $text = Str::replace('#print_width#', '#print_max#', $text);
            $text = Str::replace('#print_bigger#', '#print_max#', $text);

            $message->text = $text;
            $message->save();
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
