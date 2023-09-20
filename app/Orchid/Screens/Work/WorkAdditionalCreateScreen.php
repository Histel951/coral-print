<?php

namespace App\Orchid\Screens\Work;

use App\Events\WorkAdditionalCacheClearEvent;
use App\Models\Formula;
use App\Models\WorkAdditional;
use App\Models\WorkAdditionalType;
use App\Orchid\Layouts\WorkAdditionalTypeNameListener;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class WorkAdditionalCreateScreen extends Screen
{
    private WorkAdditionalType $workAdditionalType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'workAdditionalType' => WorkAdditionalType::find($request->get('work_additional_type_id')),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание доп. работы';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::back(BreadCrumbsCookie::WorkAdditionalPrint, 'platform.works.additionals', [
                'filter[work_additional_type_id]' => \request('work_additional_type_id'),
            ]),
            Button::make('Сохранить')->method('save'),
        ];
    }

    public function asyncWorkAdditionalTypeName(string $workAdditionalName): array
    {
        return [
            'work_additional_name' => $workAdditionalName,
            'work_additional_type_name' => transliterate($workAdditionalName),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            WorkAdditionalTypeNameListener::class,
            Layout::columns([
                Layout::rows([
                    Relation::make('workAdditional.formula_id')
                        ->title('Формула')
                        ->fromModel(Formula::class, 'value', 'id')
                        ->required(),

                    Select::make('workAdditional.color')
                        ->title('Цвет')
                        ->options([
                            '#309aee' => 'blue',
                            '#0ea586' => 'green',
                            '#fda601' => 'orange',
                            '#652bb3' => 'violet',
                            '#032c62' => 'darkblue',
                        ])
                        ->required(),

                    Input::make('workAdditional.code')
                        ->title('Тэг')
                        ->placeholder('#люверсы')
                        ->required(),

                    Input::make('workAdditional.weight')
                        ->title('Вес')
                        ->type('number')
                        ->placeholder('80')
                        ->required()
                        ->value(0),

                    Input::make('workAdditional.volume')
                        ->title('Объём')
                        ->value(0)
                        ->type('number')
                        ->required()
                        ->placeholder('235'),

                    Input::make('workAdditional.times')
                        ->title('Повторения')
                        ->type('number')
                        ->value(1)
                        ->required()
                        ->placeholder('1'),

                    Input::make('workAdditionalType.name')
                        ->title('Тип доп работы')
                        ->readonly()
                        ->canSee((int) \request('work_additional_type_id', 0)),

                    Input::make('workAdditionalType.id')
                        ->type('number')
                        ->disabled(!(int) \request('work_additional_type_id', 0))
                        ->hidden(),

                    Select::make('workAdditionalType.id')
                        ->title('Тип доп работы')
                        ->fromModel(WorkAdditionalType::class, 'name', 'id')
                        ->disabled(!(int) \request('work_additional_type_id', 0))
                        ->canSee(!(int) \request('work_additional_type_id', 0)),
                ]),
            ]),
        ];
    }

    public function save(WorkAdditional $workAdditional, Request $request): RedirectResponse
    {
        if (
            $workAdditional
                ->fill(
                    Arr::collapse([
                        [
                            'name' => $request->get('work_additional_name'),
                            'type_name' => $request->get('work_additional_type_name'),
                            'work_additional_type_id' => $request->get('workAdditionalType')['id'] ?? null,
                        ],
                        $request->get('workAdditional'),
                    ]),
                )
                ->save()
        ) {
            event(new WorkAdditionalCacheClearEvent());
            Alert::success('Доп работа успешно создана.');

            return redirect()->route('platform.works.additional.edit', $workAdditional);
        } else {
            Alert::warning('Печать не создана.');
        }
    }
}
