<?php

namespace App\Services;

use App\Models\Call;

final class CallService
{
    public const STATUS_NEW = 1;
    public const STATUS_PROCESSED = 2;

    /**
     * @param string $phone
     * @return bool
     * Обработка данных формы модалки звонка
     */
    public function callback(string $phone): bool
    {
        $model = new Call();
        $model->phone = $phone;

        return $model->save();
    }

    /**
     * @param int $status
     * @return string
     */
    public function getStatusText(int $status): string
    {
        $statuses = [
            self::STATUS_NEW => 'Новый',
            self::STATUS_PROCESSED => 'Обработан',
        ];

        return $statuses[$status] ?? $statuses[self::STATUS_NEW];
    }
}
