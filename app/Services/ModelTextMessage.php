<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface ModelTextMessage
{
    /**
     * Устанавливает сообщение в зависимости от модельки
     * @param string $message
     * @param Model $model
     * @param string $fieldName
     * @return void
     */
    public function set(string $message, string $fieldName, Model $model): void;

    /**
     * Изменяет поля в зависимости от модельки
     * @param Model $model
     * @param string $fieldName
     * @return void
     */
    public function changeField(Model &$model, string $fieldName): void;

    /**
     * Изменяет все поля модели зависимости которых есть в базе
     * @param Model $model
     * @return void
     */
    public function changeAllFields(Model &$model): void;
}
