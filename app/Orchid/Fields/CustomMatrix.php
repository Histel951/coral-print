<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Matrix;

class CustomMatrix extends Matrix
{
    /**
     * @var string
     */
    protected $view = 'orchid.fields.custom-matrix';

    /**
     * @param Field[] $fields
     * @return $this
     */
    public function additionalFields(array $fields): self
    {
        return $this->set('additional_fields', $fields);
    }
}
