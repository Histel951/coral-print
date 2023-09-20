<?php

use App\Models\Pages\MenuItem;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        DB::beginTransaction();

        try {
            $root = MenuItem::create([
                'parent_id' => null,
                'name' => 'Root',
                'url' => null,
                'order' => 0,
                'is_visible' => false,
            ]);

            $typesConf = [
                'parent_id' => $root->id,
                'url' => null,
            ];

            $typesOrderCount = 1;

            $production = MenuItem::create(
                array_merge(
                    $typesConf,
                    [
                        'name' => 'Продукция',
                        'order' => $typesOrderCount++,
                    ]
                )
            );

            $productionNames = [
                'Печать визиток',
                'Печать листовок',
                'Печать рекламных буклетов',
                'Печать наклеек',
                'Печать календарей',
                'Печать конвертов',
                'Печать бланков',
                'Печать флаеров',
                'Печать объявлений',
                'Печать открыток',
                'Печать каталогов',
                'Печать презентаций',
                'Печать чертежей',
                'Печать баннеров',
                'Печать плакатов',
                'Печать стикеров',
                'Печать брошюр',
                'Печать этикеток',
                'Блокноты',
                'Пригласительные',
                'Грамоты',
                'Сертификаты',
                'Благодарности',
                'Ценники',
                'Бирки',
                'Меню',
                'Журналы',
                'Лифлеты',
                'Документация',
                'Бейджи',
                'Билеты',
                'Купоны',
                'Тетради на заказ',
                'Печать на холсте',
            ];

            $productionUrls = [
                '/vizitki',
                '/pechat-listovok',
                '/pechat-bukletov',
                '/pechat-nakleek',
                '/pechat-kalendarey',
                '/pechat-konvertov',
                '/pechat-blankov',
                '/pechat-flaerov',
                '/pechat-obyavleniy',
                '/pechat-otkritok',
                '/pechat-katalogov',
                '/pechat-prezentaciy',
                '/pechat-chertezhej',
                '/pechat-bannerov',
                '/pechat-plakatov',
                '/pechat-stikerov',
                '/pechat-broshyur',
                '/pechat-etiketok',
                '/bloknoty',
                '/priglasitelnye',
                '/gramoty',
                '/sertifikaty',
                '/blagodarnosti',
                '/cenniki',
                '/birki',
                '/menyu',
                '/zhurnaly',
                '/liflety',
                '/dokumentaciya',
                '/beydzhi',
                '/bilety',
                '/kupony',
                '/tetradi',
                '/pechat-na-holste',
            ];

            $productionOrderCount = 1;

            for ($i = 0; $i < count($productionNames); $i++) {
                MenuItem::create([
                    'parent_id' => $production->id,
                    'name' => $productionNames[$i],
                    'url' => $productionUrls[$i],
                    'order' => $productionOrderCount++,
                ]);
            }

            $service = MenuItem::create(
                array_merge(
                    $typesConf,
                    [
                        'name' => 'Услуги',
                        'order' => $typesOrderCount++
                    ]
                )
            );

            $serviceNames = [
                'Баннеры 2',
                'Бейджи',
                'Билеты',
                'Бирки',
                'Благодарности',
                'Бланки',
                'Блокноты',
                'Брошюры',
                'Буклеты',
                'Визитки',
                'Грамоты',
                'Документация',
                'Журналы',
            ];

            $serviceOrderCount = 1;

            foreach ($serviceNames as $serviceName) {
                MenuItem::create([
                    'parent_id' => $service->id,
                    'name' => $serviceName,
                    'order' => $serviceOrderCount++,
                ]);
            }

            $constructor = MenuItem::create(
                array_merge(
                    $typesConf,
                    [
                        'name' => 'Конструктор макетов',
                        'order' => $typesOrderCount++,
                    ]
                )
            );

            $constructorNames = [
                'Баннеры 3',
                'Бейджи',
                'Билеты',
                'Бирки',
                'Благодарности',
                'Бланки',
                'Блокноты',
                'Брошюры',
                'Буклеты',
                'Визитки',
                'Грамоты',
                'Документация',
                'Журналы',
            ];

            $constructorOrderCount = 1;

            foreach ($constructorNames as $constructorName) {
                MenuItem::create([
                    'parent_id' => $constructor->id,
                    'name' => $constructorName,
                    'order' => $constructorOrderCount++,
                ]);
            }

            $worksPhotos = MenuItem::create(
                array_merge(
                    $typesConf,
                    [
                        'name' => 'Фото работ',
                        'order' => $typesOrderCount++,
                    ]
                )
            );

            $worksPhotosNames = [
                'Баннеры 4',
                'Бейджи',
                'Билеты',
                'Бирки',
                'Благодарности',
                'Бланки',
                'Блокноты',
                'Брошюры',
                'Буклеты',
                'Визитки',
                'Грамоты',
                'Документация',
                'Журналы',
            ];

            $worksOrderCount = 1;

            foreach ($worksPhotosNames as $worksPhotosName) {
                MenuItem::create([
                    'parent_id' => $worksPhotos->id,
                    'name' => $worksPhotosName,
                    'order' => $worksOrderCount++,
                ]);
            }

            MenuItem::create([
                'parent_id' => $root->id,
                'name' => 'Доставка и оплата',
                'url' => '/payment-delivery',
                'order' => $typesOrderCount++,
            ]);

            MenuItem::create([
                'parent_id' => $root->id,
                'name' => 'Контакты',
                'url' => '/contacts',
                'order' => $typesOrderCount,
            ]);

            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            throw $e;
        }
    }
};
