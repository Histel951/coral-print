<?php

namespace App\Orchid\Fields;

use App\Models\Gallery\GalleryFile;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Orchid\Screen\Field;
use Orchid\Support\Assert;

class FileManagerSelector extends Field
{
    /**
     * {@inheritdoc}
     */
    protected $view = 'orchid.fields.file-manager-selector';

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        'value' => null,
    ];

    /**
     * {@inheritdoc}
     */
    protected $inlineAttributes = ['value', 'name'];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            $value = $this->get('value');

            // Пустота
            if (blank($value)) {
                return $this->set('value', '[]');
            }

            // OLD json
            if (Str::isJson($value)) {
                return $this->set('value', $value);
            }

            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }

            $value = Arr::wrap($value);

            if (Assert::isIntArray($value)) {
                $value = GalleryFile::findMany($value)
                    ->map(function (GalleryFile $galleryFile) {
                        return $galleryFile->only(['id', 'alt', 'description', 'basename', 'path']);
                    })
                    ->toJson();

                return $this->set('value', $value);
            }

            throw new InvalidArgumentException();
        });
    }
}
