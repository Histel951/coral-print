<?php

namespace App\Services;

use App\Models\FileUpload;
use App\Models\Gallery\Gallery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;

final class FileUploadService
{
    public const TYPES = [
        'avatar' => '/images/avatars',
        'order-photos' => '/images/order-photos',
        'designs' => '/images/designs',
        'temp-designs' => '/images/temp/designs',
        'requisites' => '/docs/temp/requisites',
    ];

    /**
     * @param array $request
     * @return array
     * Обработка загрузки файлов через js (dropzone)
     */
    public function upload(array $request): array
    {
        $result = [];
        if (array_key_exists('type', $request) && array_key_exists('file', $request)) {
            foreach ($request['file'] as $uploadFile) {
                $path = $uploadFile->store(FileUploadService::TYPES[$request['type']] ?? '', 'public');
                $file = new FileUpload();
                $file->path = $path;
                $file->original_name = $uploadFile->getClientOriginalName();
                $file->is_temp = true;
                $file->save();
                $result[] = $file->id;
            }
        }

        return $result;
    }

    public function delete(int $id): void
    {
        $file = FileUpload::findOrFail($id);
        Storage::disk('public')->delete($file->path);
        $file->delete();
    }

    /**
     * @param string $path
     * @param bool $withoutExtension
     * @return string
     */
    public function getClearName(string $path, bool $withoutExtension = false): string
    {
        $result = substr_replace($path, '', 0, strrpos($path, '/') + 1);
        if ($withoutExtension) {
            $result = substr_replace($result, '', strrpos($result, '.'));
        }

        return $result;
    }

    /**
     * @param array $files
     * @param $group
     * @return array
     */
    public function getAttachmentIds(array|Collection $files, $group = ''): array
    {
        $names = [];
        foreach ($files as $file) {
            $names[] = $this->getClearName($file->path, true);
        }

        return array_column(
            Attachment::whereIn('name', $names)
                ->where('group', $group)
                ->distinct('name')
                ->get('id')
                ->toArray(),
            'id',
        );
    }

    public function addGalleryFile(array $request)
    {
        $model = FileUpload::query()->create([
            'path' => $request['url'],
            'fileable_id' => $request['gallery_id'] ?: null,
            'fileable_type' => Gallery::class,
            'is_temp' => true,
        ]);

        return $model->id;
    }
}
