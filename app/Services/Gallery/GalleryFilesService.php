<?php

namespace App\Services\Gallery;

use App\Models\Gallery\Gallery;
use Illuminate\Support\Arr;

class GalleryFilesService
{
    public function syncFromRequest(Gallery $gallery, array $files = []): void
    {
        $originalFiles = $gallery->files;

        $files = collect($files)->map(function (array $data) use ($gallery) {
            $galleryFile = $gallery->files()->findOrNew(Arr::pull($data, 'id'));

            $galleryFile->fill($data);

            $galleryFile->save();

            return $galleryFile;
        });

        $originalFiles->diff($files)->each->delete();
    }
}
