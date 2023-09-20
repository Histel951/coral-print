<?php

namespace App\Services;

use App\Models\Pages\MenuItem;

class MenuService
{
    public const ROOT_ID = 1;
    private const CACHE_KEY = 'menu-items-tree';
    private const CACHE_TAGS = ['main_menu', 'menu_items'];

    public function getMenuItemsTree(): array
    {
        $cache = \Cache::tags(self::CACHE_TAGS);

        if ($cache->has(self::CACHE_KEY)) {
            return $cache->get(self::CACHE_KEY);
        }

        $items = MenuItem::all();

        $types = array_values(
            $items->where('parent_id', self::ROOT_ID)
                ->sort(fn ($a, $b) => $a->order > $b->order)
                ->toArray()
        );

        foreach ($types as $key => $type) {
            $types[$key]['child_items'] = array_values(
                $items->where('parent_id', $type['id'])
                    ->sort(fn ($a, $b) => $a->order > $b->order)
                    ->toArray()
            );
        }

        $cache->forever(self::CACHE_KEY, $types);

        return $types;
    }

    /**
     * @throws \Exception
     */
    public function handle(array $data, ?int $id): void
    {
        \DB::beginTransaction();

        try {
            $data['order']++;

            \DB::update(
                "UPDATE menu_items SET `order` = `order` + 1 WHERE `order` >= ? AND parent_id = ?;",
                [$data['order'], $data['parent_id']]
            );

            if ($id === null) {
                MenuItem::create($data);
            } else {
                $menuItem = MenuItem::findOrFail($id);
                $menuItem->update($data);
            }

            \DB::unprepared("SET @counter = 0;");
            \DB::update(
                <<<SQL
UPDATE menu_items
SET `order` = (@counter := @counter + 1)
WHERE parent_id = ?
ORDER BY `order`;
SQL,
                [$data['parent_id']]
            );

            $this->clearCache();

            \DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollBack();

            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function deleteMenuItem(int $id): void
    {
        try {
            $menu = MenuItem::find($id);
            $menu->delete();
            $this->clearCache();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            throw $e;
        }
    }

    private function clearCache(): void
    {
        \Cache::tags(self::CACHE_TAGS)->forget(self::CACHE_KEY);
    }
}
