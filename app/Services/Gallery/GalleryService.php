<?php

namespace App\Services\Gallery;

use App\Models\Gallery\Gallery;
use Illuminate\Support\Arr;

class GalleryService
{
    public function createFromRequest(array $filledData): Gallery
    {
        $gallery = new Gallery();

        $gallery->calculator()->associate(Arr::pull($filledData, 'calculator_id'));
        $gallery->calculatorType()->associate(Arr::pull($filledData, 'calculator_type_id'));
        $gallery->fill($filledData);

        $gallery->save();

        return $gallery;
    }

    public function updateFromRequest(Gallery $gallery, array $filledData): Gallery
    {
        $gallery->calculator()->associate(Arr::pull($filledData, 'calculator_id'));
        $gallery->fill($filledData);

        $gallery->save();

        return $gallery;
    }
}
