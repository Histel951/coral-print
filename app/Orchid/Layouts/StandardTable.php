<?php

namespace App\Orchid\Layouts;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

abstract class StandardTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = '';

    /**
     * Доп данные для расширения вью таблицы
     * @var array
     */
    protected array $additionalViewData = [];

    protected $template = 'layouts.table';

    /**
     * Имя роута редактирования
     * @var string
     */
    protected string $editRoute = '';

    /**
     * Иконка кнопки редактирования
     * @var string
     */
    protected string $editIcon = 'arrow-right';

    /**
     * ID <tr> тега каждой строки в шаблоне
     * @var string
     */
    protected string $trItemId = 'tr-item-{id}';

    /**
     * ID тега <tbody> таблицы
     * @var string
     */
    protected string $tBodyId = 'table-tbody';

    /**
     * Кнопка "Добавить ряд" сверху
     * @var bool
     */
    protected bool $isAddRowUp = false;

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')->sort(),

            ...$this->standardColumns(),

            //            TD::make('created_at', 'Создан')
            //                ->sort(),
            //
            //            TD::make('updated_at', 'Обновлён')
            //                ->sort(),
        ];
    }

    /**
     * Доп данные для вью таблицы
     * @param Repository $repository
     * @return array
     */
    protected function viewData(Repository $repository): array
    {
        return [];
    }

    /**
     * Возвращает коллекцию всех активных колонок
     * @return Collection
     */
    public function getColumns(): Collection
    {
        return collect($this->columns())->filter(static fn (TD $column) => $column->isSee());
    }

    /**
     * @param Repository $repository
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        $this->additionalViewData = $this->viewData($repository);

        $viewData = Arr::collapse([parent::build($repository)->getData(), $this->additionalViewData]);
        $viewData['tBodyId'] = $this->tBodyId;
        $viewData['trItemId'] = $this->trItemId;
        $viewData['isAddRowUp'] = $this->isAddRowUp;

        return view($this->template, $viewData);
    }

    public function delete(Model $model): RedirectResponse
    {
        $model->delete();

        Toast::success('Данные успешно удалены');

        return redirect()->route('platform.calculators');
    }

    /**
     * Метод оборачиваемый в columns
     * Должен возвращать колонки для отображения таблицы
     * @return iterable
     */
    abstract protected function standardColumns(): iterable;
}
