<?php

use App\Models\Calculator;
use App\Models\Preview;
use App\Models\PreviewBracer;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $bracers = [
            [
                'name' => 'скобы',
                'calculators' => [3855, 3860]
            ],
            [
                'name' => 'пружина',
                'calculators' => [3856, 3858, 3859]
            ],
            [
                'name' => 'клей',
                'calculators' => [3866]
            ],
            [
                'name' => 'болты',
                'calculators' => [3881]
            ],
        ];

        foreach ($bracers as $bracer) {
            $newBracer = PreviewBracer::query()->create([
                'name' => $bracer['name'],
                'type' => transliterate($bracer['name'])
            ]);

            foreach ($bracer['calculators'] as $calculatorId) {
                $calculatorPreviews = Calculator::query()->find($calculatorId)->previews();

                $calculatorPreviews->each(fn (Preview $preview) => $preview->update([
                    'preview_bracer_id' => $newBracer->getKey()
                ]));
            }
        }
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
