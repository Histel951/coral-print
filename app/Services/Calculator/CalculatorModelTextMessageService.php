<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use App\Models\ModelTextDataMessage;
use App\Services\ModelTextMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Нужен для отображения данных в полях с разными названиями,
 * используя одни и те же модельки и данные, в разных калькуляторах
 * Например в одном калькуляторе нужно отобразить селект с "{width}x{height}мм", а в другом "{type}, {width}x{height}мм"
 * Уходим от хардкода
 * @package CalculatorModelTextMessageService
 */
class CalculatorModelTextMessageService implements ModelTextMessage
{
    /**
     * Калькулятор по которому будут тянуться сообщения
     * @param Calculator $calculator
     */
    public function __construct(private readonly Calculator $calculator)
    {
    }

    /**
     * Устанавливает сообщение модели в зависимости от калькулятора, удаляя при этом другие сообщения связанные
     * с этим калькулятором, моделью и полем
     * @param string $message
     * @param Model $model
     * @param string $fieldName
     * @return void
     */
    public function set(string $message, string $fieldName, Model $model): void
    {
        $this->calculator
            ->modelTextDataMessage()
            ->where('model_class', $model::class)
            ->delete();

        $newModelText = $this->calculator->modelTextDataMessage()->create([
            'model_class' => $model::class,
            'message' => $message,
        ]);

        $this->calculator->modelTextDataMessage()->updateExistingPivot($newModelText, [
            'model_field' => $fieldName,
        ]);
    }

    /**
     * Возвращает сообщение модели в зависимости от калькулятора и поля
     * @param Model $model
     * @param string $fieldName
     * @param bool $isInt
     * @param int|null $printFormId
     * @return void
     */
    public function changeField(Model &$model, string $fieldName, bool $isInt = false, int $printFormId = null): void
    {
        $cacheKey = cache_key('calculator:model:text:message', [
            'calculator_id' => $this->calculator,
            'model_id' => $model->id,
            'field_name' => $fieldName,
            'model_class' => $model::class,
        ]);

        $messageQuery = $this->calculator->modelTextDataMessage();

        if ($printFormId) {
            $messageQuery->wherePivot('print_form_id', $printFormId);
        }

        $message = $messageQuery
            ->withPivot('is_use_post_text_icon')
            ->where('model_class', $model::class)
            ->wherePivot('model_field', $fieldName)
            ->first();

        $model->isUsePostTextIcon = (bool) $message->pivot['is_use_post_text_icon'];

        $cache = Cache::tags(['calculator', 'model', 'text', 'message']);

        $model->{$fieldName} = $cache->remember($cacheKey, now()->addDays(7), function () use (
            &$model,
            $isInt,
            $message,
        ): string {
            return $this->replaceModelPropsInMessage(message: $message->message, model: $model, isInt: $isInt);
        });
    }

    /**
     * Заменяет на нужные сообщения во всех имеющихся полях в базе
     * @param Model $model
     * @param int|null $printFormId
     * @return void
     */
    public function changeAllFields(Model &$model, int $printFormId = null): void
    {
        $messagesQuery = $this->calculator->modelTextDataMessage();

        if ($printFormId) {
            $messagesQuery->wherePivot('print_form_id', $printFormId);
        }

        $messagesQuery
            ->withPivot('model_field', 'is_int')
            ->each(
                fn (ModelTextDataMessage $textDataMessage) => $this->changeField(
                    model: $model,
                    fieldName: $textDataMessage->pivot['model_field'],
                    isInt: $textDataMessage->pivot['is_int'],
                    printFormId: $printFormId,
                ),
            );
    }

    /**
     * Заменяет все найденные параметры из текста, по шаблону #{field}#
     * @param string $message
     * @param Model $model
     * @param bool $isInt
     * @return string
     */
    private function replaceModelPropsInMessage(string $message, Model $model, bool $isInt): string
    {
        $isChanged = !$isInt;
        foreach ($model->toArray() as $field => $value) {
            if ($isInt && !(int) $value) {
                continue;
            }

            if (Str::match("#{$field}#", $message)) {
                $isChanged = true;
                $message = Str::replace("#{$field}#", $value, $message);
            }
        }

        return $isChanged ? $message : '';
    }
}
