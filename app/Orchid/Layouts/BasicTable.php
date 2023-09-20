<?php

namespace App\Orchid\Layouts;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BasicTable extends Table
{
    protected $modalEditTitle = 'Редактировать запись';
    protected $modalDeleteTitle = 'Удалить запись';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'table';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [];
    }

    /**
     * Возвращает кнопку редактирования
     * @param Model $model
     * @return Field
     */
    protected function getEditBtn(Model $model): Field
    {
        return ModalToggle::make('Редактировать')
            ->modal('asyncEditModal')
            ->modalTitle($this->modalEditTitle)
            ->method('saveData')
            ->icon('note')
            ->asyncParameters($model->toArray());
    }

    /**
     * Возвращает кнопку удаления
     * @param Model $model
     * @return Field
     */
    protected function getDeleteBtn(Model $model): Field
    {
        return ModalToggle::make('Удалить')
            ->modal('asyncDeleteModal')
            ->modalTitle($this->modalDeleteTitle)
            ->method('deleteData')
            ->icon('cross')
            ->asyncParameters(['id' => $model->id]);
    }

    /**
     * Возвращает группу из кнопки редактирования и удаления
     * @param Model $model
     * @return Field
     */
    protected function getEditDelGroupBtn(Model $model): Group
    {
        return Group::make([$this->getEditBtn($model), $this->getDeleteBtn($model)]);
    }
}
