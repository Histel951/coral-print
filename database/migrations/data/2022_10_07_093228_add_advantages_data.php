<?php

use App\Models\Advantages;
use App\Models\CalculatorType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Orchid\Attachment\File;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $image1 = (new File(new UploadedFile(public_path('images/advantages/1-md.png'), '1-md.png')))->load();
        $image2 = (new File(new UploadedFile(public_path('images/advantages/2-md.png'), '2-md.png')))->load();

        $advantages = [
            [
                'title' => 'Уникальное качество печати',
                'description' => '<p>
                                Лазерная печать на праймированой пленке. <br/>
                                Отличная цветопередача. <br/>
                                Пропечатка мельчайших деталей.
                            </p>',
                'image_id' => $image1->getKey(),
                'calculator_types' => CalculatorType::all()->pluck('id')
            ],
            [
                'title' => 'Умеем белым по прозрачному',
                'description' => '<p>
                        Супер кроющая УФ-печать <br/>
                        на прозрачных и темных пленках.<br/>
                        Всегда печатаем белый в четыре слоя.
                    </p>',
                'image_id' => $image2->getKey(),
                'calculator_types' => CalculatorType::all()->pluck('id')
            ]
        ];

        foreach ($advantages as $advantage) {
            foreach ($advantage['calculator_types'] as $calculator_type) {
                unset($advantage['calculator_types']);
                Advantages::query()->create(Arr::collapse([
                    $advantage,
                    [
                        'calculator_type_id' => $calculator_type
                    ]
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
