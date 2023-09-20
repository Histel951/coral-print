<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait SyncDetaching
{
    /**
     * Синхронизует только уникальные ключи для таблиц many-to-many, обёртка над sync
     * @param BelongsToMany $relation
     * @param array|Collection $data массив ids [1, 2, 3] или ассоциативный с уникальным ключом
     * @param string $key уникальный ключ
     * @return void
     */
    public function syncUnique(BelongsToMany $relation, array|Collection $data, string $key = 'id'): void
    {
        if (!$data instanceof Collection) {
            $data = collect($data);
        }

        if ($first = $data->first()) {
            if (isset($first[$key])) {
                $data = $data->unique($key)?->pluck($key);
            }

            $relation->sync($data);
        }
    }
}
