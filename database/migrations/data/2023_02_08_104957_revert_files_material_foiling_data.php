<?php

use App\Models\FoilingColor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $foilingColorsData = json_decode('[
              {
                "id": 23,
                "title": "Только фольга",
                "types": [
                   {
                    "id": 63,
                    "name": "Без фольги"
                   },
                  {
                    "id": 64,
                    "name": "Глянцевое золото (220)",
                    "image": "images/foilings/gold.svg",
                    "image_name": "gold.svg"
                  },
                  {
                    "id": 65,
                    "name": "Глянцевое серебро (Alufin)",
                    "image": "images/foilings/2.svg",
                    "image_name": "2.svg"
                  },
                  {
                    "id": 66,
                    "name": "Бронза металлик (334)",
                    "image": "images/foilings/3.svg",
                    "image_name": "3.svg"
                  },
                  {
                    "id": 67,
                    "name": "Красный металлик (392)",
                    "image": "images/foilings/4.svg",
                    "image_name": "4.svg"
                  },
                  {
                    "id": 68,
                    "name": "Малиновый металлик (360)",
                    "image": "images/foilings/5.svg",
                    "image_name": "5.svg"
                  },
                  {
                    "id": 69,
                    "name": "Титан металлик (377)",
                    "image": "images/foilings/6.svg",
                    "image_name": "6.svg"
                  },
                  {
                    "id": 70,
                    "name": "Салатовый металлик (390)",
                    "image": "images/foilings/7.svg",
                    "image_name": "7.svg"
                  },
                  {
                    "id": 71,
                    "name": "Синий металлик (391)",
                    "image": "images/foilings/8.svg",
                    "image_name": "8.svg"
                  },
                  {
                    "id": 72,
                    "name": "Лазерный хром (Metal Laser)",
                    "image": "images/foilings/9.svg",
                    "image_name": "9.svg"
                  }
                ]
              },
              {
                "id": 24,
                "title": "Фольга с печатью",
                "types": [
                   {
                    "id": 63,
                    "name": "Без фольги"
                   },
                  {
                    "id": 64,
                    "name": "Глянцевое золото (220)",
                    "image": "images/foilings/gold.svg",
                    "image_name": "gold.svg"
                  },
                  {
                    "id": 65,
                    "name": "Глянцевое серебро (Alufin)",
                    "image": "images/foilings/2.svg",
                    "image_name": "2.svg"
                  },
                  {
                    "id": 66,
                    "name": "Бронза металлик (334)",
                    "image": "images/foilings/3.svg",
                    "image_name": "3.svg"
                  },
                  {
                    "id": 67,
                    "name": "Красный металлик (392)",
                    "image": "images/foilings/4.svg",
                    "image_name": "4.svg"
                  },
                  {
                    "id": 68,
                    "name": "Малиновый металлик (360)",
                    "image": "images/foilings/5.svg",
                    "image_name": "5.svg"
                  },
                  {
                    "id": 69,
                    "name": "Титан металлик (377)",
                    "image": "images/foilings/6.svg",
                    "image_name": "6.svg"
                  },
                  {
                    "id": 70,
                    "name": "Салатовый металлик (390)",
                    "image": "images/foilings/7.svg",
                    "image_name": "7.svg"
                  },
                  {
                    "id": 71,
                    "name": "Синий металлик (391)",
                    "image": "images/foilings/8.svg",
                    "image_name": "8.svg"
                  },
                  {
                    "id": 72,
                    "name": "Лазерный хром (Metal Laser)",
                    "image": "images/foilings/9.svg",
                    "image_name": "9.svg"
                  }
                ]
              }
            ]', true);

        foreach ($foilingColorsData as $foilingColorsDatum) {
            foreach ($foilingColorsDatum['types'] as $type) {
                $foiling = FoilingColor::query()->find($type['id']);

                if (isset($type['image'])) {
                    $file = new UploadedFile(public_path($type['image']), $type['image_name']);
                    $attachment = (new File($file))->allowDuplicates()->load();

                    $foiling->update([
                        'image_id' => $attachment->getKey()
                    ]);
                }
            }
        }
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
