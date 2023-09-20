<?php

namespace App\Orchid\Fields;

use App\Orchid\Traits\Methodtable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Field;

/**
 * @method self text($value = true)
 * @method self contenteditable(bool $value = true)
 * @method self requestmethod(string $value = true)
 * @method self field(string $value = true)
 * @method self mainurl(string $url = true)
 */
class Span extends Field
{
    use Methodtable;

    protected $view = 'partials.orchid.fields.span';

    protected $attributes = [
        'contenteditable' => false,
        'method' => null,
        'text' => '',
        'url' => '',
        'mainurl' => '',
        'requestmethod' => 'post',
        'field' => null,
        'style' => '',
    ];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            $url = $this->get('mainurl') ?: request()->header('ORCHID-ASYNC-REFERER', url()->current());

            $query = http_build_query($this->get('parameters', []));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);

            if ($action) {
                $this->set('url', $action);
            }
        });
    }

    /**
     * Создаёт текстовое contenteditable поле,
     * при изменении которого отправляется запрос на указанный метод, с указанным
     * key (по умолчанию id) из переданной модели
     * @param string $method
     * @param string $field
     * @param Model $model
     * @param string|null $mainUrl
     * @param string $key
     * @return $this
     */
    public function changeField(
        string $method,
        string $field,
        Model $model,
        string $mainUrl = null,
        string $key = 'id',
    ): self {
        return $this->field($field)
            ->mainurl($mainUrl)
            ->text($model->$field ?? '')
            ->contenteditable()
            ->method($method, [
                $key => $model->$key,
            ]);
    }
}
