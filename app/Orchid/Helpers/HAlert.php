<?php

namespace App\Orchid\Helpers;

use Orchid\Support\Facades\Toast;

class HAlert
{
    public const SUCCESS_MSG = 'Данные успешно обновлены';
    public const ERROR_MSG = 'В процессе обновления произошла ошибка';

    public static function alert($success = false): void
    {
        if ($success) {
            Toast::success(self::SUCCESS_MSG);
        } else {
            Toast::error(self::ERROR_MSG);
        }
    }
}
