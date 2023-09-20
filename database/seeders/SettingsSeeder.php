<?php

namespace Database\Seeders;

use App\Models\CommonSetting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommonSetting::query()->create([
            'email' => 'info@coral-print.ru',
            'email_complain' => 'dedli888@gmail.com',
            'phone' => '+7 495 663-73-81',
            'discount_value' => '10',
            'yandex_review_link' => 'https://yandex.ru/profile/232507004696?intent=reviews&utm_source=badge&utm_medium=rating&utm_campaign=v1',
            'google_review_link' => 'https://www.google.com/maps/place/Coral+Print+-+Визитки,+календари+и+другая+типография+в+Москве/@55.835578,37.500133,20z/data=!4m14!1m6!3m5!1s0x0:0xb4978b1950cad3e1!2zSW5kaSDQsdGM0Y7RgtC4LdC_0YDQvtGB0YLRgNCw0L3RgdGC0LLQvg!8m2!3d55.8364605!4d37.4970813!3m6!1s0x46b5386b2e3ba86d:0x8d5fd6dcd2085ca2!8m2!3d55.835579!4d37.5002009!9m1!1b1?hl=ru',
            'instagram_review_link' => 'https://www.instagram.com/p/CDI2xyCMzVr/',
            'instagram_link' => 'https://www.instagram.com/coral_print/',
            'vk_link' => 'https://vk.com/club29308622',
            'bank_details' => 'ИНН: 7714755828 Московский банк Сбербанка России ОАО</br>
БИК: 044525225 КПП: 771401001</br>
Р/с: 40702810338000024289 ОКПО: 88383322',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
