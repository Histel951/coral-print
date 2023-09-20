<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([[
            'name' => 'Производство и офис',
            'metro' => 'Водный стадион',
            'address' => 'Москва, ул. Выборгская, 22 стр 3',
            'address_link' => 'https://yandex.ru/maps/org/coral_print/232507004696/?from=mapframe&ll=37.500450%2C55.835711&z=15',
            'address_route_link' => 'https://yandex.ru/maps/213/moscow/?ll=37.502639%2C55.836472&mode=usermaps&source=constructorLink&um=constructor%3Af7f7f00812c1407eff5573a52ed576d6e79b39c3dc3c3e8da42cefe58aa106d1&z=17',
            'work_time' => 'будние дни с 10:00 до 19:00.',
            'text_route' => '
            <h3>Для консультаций и самовывоза некрупных заказов</h3>
                            <p>Станция метро «Водный стадион», последний вагон из центра. Следуйте по ул. Адмирала Макарова до пересечения с ул. Выборгской и поверните ↰ налево. Мы вольготно расположились
                                на ней в центральной части дома №22, строение 3. Вход с фасада здания, под синей вывеской «Типография».<br> <a target="_blank" href="https://yandex.ru/maps/org/coral_print/232507004696/?from=mapframe&amp;ll=37.500450%2C55.835711&amp;z=15">На карте↗</a></p>
                            <h3>Для самовывоза крупных заказов на авто</h3>
                            <p>Используйте въезд на ул. Выборгской, у дома №22, строение 1. Въезд сразу после заправки.<br> <a target="_blank" href="https://yandex.ru/maps/213/moscow/?ll=37.502639%2C55.836472&amp;mode=usermaps&amp;source=constructorLink&amp;um=constructor%3Af7f7f00812c1407eff5573a52ed576d6e79b39c3dc3c3e8da42cefe58aa106d1&amp;z=17">Схема проезда на карте↗</a></p>
                        ',
            'created_at' => date('Y-m-d H:i:s'),
        ], [
            'name' => 'Пункт выдачи «Белорусская»',
            'metro' => 'Белорусская',
            'address' => 'Москва, Ленинградский проспект, д. 2',
            'address_link' => 'https://yandex.ru/maps/org/coral_print/94758688153/?from=mapframe&ll=37.582596%2C55.778574&z=16',
            'address_route_link' => '',
            'work_time' => 'будние дни с 10:00 до 19:00,
выходные дни с 11:00 до 18:00.',
            'text_route' => '                    <p>Ближайшая станция метро — «Белорусская». Выйдите из метро на мост Ленинградского шоссе, пройдите в сторону области через железнодорожные пути до ближайшего спуска с моста,
                                спуститесь по лестнице и пройдите под мостом по Ленинградскому проспекту к дому №2. В этом здании расположен «ВкусВилл», вход в наш пункт выдачи расположе в торце дома
                                справа, под вывеской фотоуслуг.<br> <a target="_blank" href="https://yandex.ru/maps/org/coral_print/94758688153/?from=mapframe&amp;ll=37.582596%2C55.778574&amp;z=16">На карте↗</a></p>',
            'created_at' => date('Y-m-d H:i:s'),
        ]]);
    }
}
