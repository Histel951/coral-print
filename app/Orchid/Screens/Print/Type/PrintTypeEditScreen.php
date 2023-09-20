<?php

namespace App\Orchid\Screens\Print\Type;

use App\Models\PrintModel;
use App\Models\PrintType;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PrintTypeEditScreen extends EditScreen
{
    public PrintType $printType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(PrintType $printType): iterable
    {
        return [
            'printType' => $printType,
            'prints' => $printType->prints,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование типа печати \"{$this->printType->name}\" [{$this->printType->id}]";
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'Тип печати' => [Layout::rows([Input::make('printType.name')->title('Название')])],

                'Печати' => [
                    Layout::rows([
                        Matrix::make('prints')
                            ->columns(['Печать' => 'id'])
                            ->fields([
                                'id' => Relation::make()->fromModel(PrintModel::class, 'name', 'id'),
                            ]),
                    ]),
                ],
            ]),
        ];
    }

    public function edit(PrintType $printType, Request $request): void
    {
        $printType->prints()->each(
            fn (PrintModel $print) => $print->update([
                'print_type_id' => null,
            ]),
        );

        collect($request->get('prints', []))
            ->unique('id')
            ->map(static function (array $print) use ($printType): void {
                PrintModel::find($print['id'])->update([
                    'print_type_id' => $printType->id,
                ]);
            });

        if ($printType->fill($request->get('printType'))->save()) {
            Alert::success('Категория успешно обновлена!');
        } else {
            Alert::warning('Категория не обновлена');
        }
    }

    public function delete(PrintType $printType): RedirectResponse
    {
        $printType->delete();

        return redirect()->route('platform.print.types');
    }
}
