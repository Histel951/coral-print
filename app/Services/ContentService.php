<?php

namespace App\Services;

use App\Models\Content;
use Flynsarmy\DbBladeCompiler\Facades\DbView;

final class ContentService
{
    public const PARENT_ID = 2668;

    public static $groupedByParentRows;
    public static $keyByContentIdRows;

    /**
     * Возвращает массив content_id
     * сгруппированный по значению parent
     * @return array
     */
    public function getGroupedByParentRows(): array
    {
        if (!isset(self::$groupedByParentRows)) {
            self::$groupedByParentRows = Content::all()
                ->groupBy('parent')
                ->toArray();
        }
        return self::$groupedByParentRows;
    }

    /**
     * Возвращает массив проиндекстированный по content_id
     * @return array
     */
    public function getKeyByContentIdRows(): array
    {
        if (!isset(self::$keyByContentIdRows)) {
            self::$keyByContentIdRows = Content::all()
                ->keyBy('content_id')
                ->toArray();
        }
        return self::$keyByContentIdRows;
    }

    /**
     * Возвращает массив всех вложенных content_id
     * для заданного parent
     * @param int $parentId
     * @return array
     */
    public function getByParentId(int $parentId): array
    {
        static $result = [];
        $rows = $this->getGroupedByParentRows();

        if (isset($rows[$parentId])) {
            foreach ($rows[$parentId] as $row) {
                $this->getByParentId($row['content_id']);
            }
        }
        $result[] = $parentId;

        return $result;
    }

    /**
     * Возвращает иерархию в виде многомерного массива
     * Дочерние эл-ты находятся в поле items родителя
     * @param int $parentId
     * @return array
     */
    public function getContentTree(int $parentId = self::PARENT_ID): array
    {
        $tree = [];
        $parentsArr = $this->getGroupedByParentRows();
        $rootNodes = $parentsArr[$parentId] ?? [];

        foreach ($rootNodes as $node) {
            $current = $node;
            if (isset($parentsArr[$node['content_id']])) {
                $current['items'] = $this->getContentTree($node['content_id']);
            }
            $tree[] = $current;
        }

        return $tree;
    }

    /**
     * Рекурсивно меняет видимость всем вложенным эл-ам
     * @param int $contentId
     * @param bool $isVisible
     * @return mixed
     */
    public function updateChildsVisible(int $contentId, bool $isVisible = false)
    {
        return Content::whereIn('content_id', $this->getByParentId($contentId))->update(['is_visible' => $isVisible]);
    }

    /**
     * Рекурсивное удаление папки со всем содержимым
     * @param int $contentId
     * @return mixed
     */
    public function deleteChilds(int $contentId)
    {
        return Content::whereIn('content_id', $this->getByParentId($contentId))->delete();
    }

    /**
     * Перенос всех вложенных эл-ов на уровень выше
     * @param int $contentId
     * @return mixed
     */
    public function moveChilds(int $contentId)
    {
        $parentId = Content::where('content_id', $contentId)
            ->get('parent')
            ->first()->parent;
        return Content::whereIn('content_id', $this->getByParentId($contentId))->update(['parent' => $parentId]);
    }

    /**
     * Рекурсивно меняет url всем вложенным эл-ам
     * @param int $contentId
     */
    public function updateChildsUrl(int $contentId)
    {
        $ids = $this->getByParentId($contentId);
        $models = Content::whereIn('content_id', $ids)->get();
        foreach ($models as $model) {
            $model->update(['url' => $this->getUrl($model)]);
        }
    }

    /**
     * Возвращает сгенерированный на основе вложенности url
     * @return string
     */
    public function getUrl($model): string
    {
        $rows = $this->getKeyByContentIdRows();
        if ($model['parent'] == self::PARENT_ID) {
            return $model['alias'];
        }

        return $this->getUrl($rows[$model['parent']]) . '/' . $model['alias'];
    }

    /**
     * @param int $contentId
     * @return bool
     */
    public function isEmptyFolder(int $contentId): bool
    {
        return !Content::where('parent', $contentId)->first();
    }

    /**
     * Возвращает массив вида [['title' => '', 'url' => ''], ...]
     * где каждый последующий эл-нт является дочерним к предыдущему
     * @param int $contentId
     * @return array
     */
    public function getBreadcrumbsArr(int $contentId): array
    {
        static $result = [];
        if ($contentId == self::PARENT_ID) {
            krsort($result);
            return $result;
        }
        $rows = $this->getKeyByContentIdRows();
        $current = $rows[$contentId];
        $result[] = [
            'title' => $current['title'],
            'url' => $current['url'],
        ];
        $this->getBreadcrumbsArr($current['parent']);
        return $result;
    }

    /**
     * Возвращает дочерние эл-ты (только прямые потомки)
     * @param int $contentId
     * @param bool $onlyFolders
     * @return iterable
     */
    public function getChildItems(int $contentId, bool $onlyFolders = false): iterable
    {
        $query = Content::with('imageFile')
            ->where('parent', $contentId)
            ->where('is_visible', 1);
        if ($onlyFolders) {
            $query->where('is_folder', 1);
        }

        return $query->get();
    }

    /**
     * @param int $contentId
     * @return int
     */
    public function getRootContentId(int $contentId): int
    {
        $model = $this->getKeyByContentIdRows()[$contentId];
        if ($model['parent'] == self::PARENT_ID) {
            return $model['content_id'];
        }

        return $this->getRootContentId($model['parent']);
    }

    /**
     * @param int $contentId
     * @return mixed
     */
    public function getContentById(int $contentId)
    {
        return Content::where('content_id', $contentId)
            ->get()
            ->first();
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function getContentByUrl(string $url)
    {
        return Content::where('url', $url)
            ->get()
            ->first();
    }

    /**
     * @return mixed
     */
    public function getRootCategoriesList()
    {
        return $this->getChildItems(ContentService::PARENT_ID)
            ->keyBy('content_id')
            ->map(fn ($v) => $v['page_title'])
            ->toArray();
    }

    public function addContentByDirective(Content $content): Content
    {
        if (null !== $content->pageTemplate && strpos($content->pageTemplate, '@content')) {
            $content->pageTemplate->template = str_replace(
                '@content',
                "@content($content->content_id)",
                $content->pageTemplate->template
            );
        }

        return $content;
    }

    public function getPageFromTemplate(Content $content)
    {
        $pageTemplate = $content->pageTemplate()->first();

        if (!$pageTemplate) {
            return $content->content;
        }

        $pageTemplate->template = str_replace(
            '@content',
            "@content($content->content_id)",
            $pageTemplate->template
        );

        return DbView::make($pageTemplate)->render();
    }
}
