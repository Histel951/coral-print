<?php

namespace App\Orchid\Screens\Work;

use App\Models\WorkAdditionalType;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class WorkAdditionalTypeEditScreen extends EditScreen
{
    public WorkAdditionalType $workAdditionalType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(WorkAdditionalType $workAdditionalType): iterable
    {
        return [
            'workAdditionalType' => $workAdditionalType,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование тип доп. работы \"{$this->workAdditionalType->name}\" [{$this->workAdditionalType->id}]";
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('workAdditionalType.name')
                        ->title('Название')
                        ->placeholder('Ламинация..'),
                ]),
            ]),
        ];
    }

    public function edit(WorkAdditionalType $workAdditionalType, Request $request): void
    {
        if ($workAdditionalType->fill($request->get('workAdditionalType'))->save()) {
            Alert::success('Тип доп. работы успешно обновлён!');
        } else {
            Alert::warning('Тип доп. работы не обновлён.');
        }
    }

    public function delete(WorkAdditionalType $workAdditionalType): RedirectResponse
    {
        $workAdditionalType->delete();

        return redirect()->route('platform.works.additional.types');
    }
}
