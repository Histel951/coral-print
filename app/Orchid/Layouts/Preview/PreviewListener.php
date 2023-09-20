<?php

namespace App\Orchid\Layouts\Preview;

use App\Models\Cutting;
use App\Models\PreviewBracer;
use App\Models\PrintForm;
use App\Models\PrintSize;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class PreviewListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'calculator_id',
        'width',
        'height',
        'description',
        'sequence',
        'dependence',
        'bracer_id',
        'pixels_sizes',
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncFields';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        return [
            Layout::rows([
                Select::make('cutting_id')
                    ->fromModel(Cutting::class, 'name', 'id')
                    ->title('Нарезка')
                    ->canSee($this->query->get('parameters_type') === 'default')
                    ->empty(),

                Select::make('form_id')
                    ->fromModel(PrintForm::class, 'name', 'id')
                    ->canSee($this->query->get('parameters_type') === 'default')
                    ->title('Форма')
                    ->empty(),

                TextArea::make('description')
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->title('Описание превью'),

                Select::make('bracer_id')
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->fromModel(PreviewBracer::class, 'name', 'id')
                    ->title('Вид скрепления')
                    ->empty(),

                Input::make('sequence')
                    ->title('Порядок')
                    ->type('number')
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->required(),

                Select::make('dependence')
                    ->title('Отображение:')
                    ->options([
                        'common' => 'Обычное',
                        'reversal' => 'В развороте',
                    ])
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->empty(),

                Input::make('width')
                    ->type('number')
                    ->value(0)
                    ->min(0)
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->title('Ширина:'),

                Input::make('height')
                    ->type('number')
                    ->value(0)
                    ->min(0)
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->title('Высота:'),

                Input::make('coefficient_w')
                    ->type('number')
                    ->disabled()
                    ->value(0)
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->title('Коэффициент ширины:'),

                Input::make('coefficient_h')
                    ->type('number')
                    ->disabled()
                    ->value(0)
                    ->canSee($this->query->get('parameters_type') === 'changeable')
                    ->title('Коэффициент высоты:'),
            ])->title('Параметры'),

            Layout::rows([
                Matrix::make('pixels_sizes')
                    ->columns([
                        'Размер' => 'print_size_id',
                        'Ширина (PX)' => 'pixels_w',
                        'Высота (PX)' => 'pixels_h',
                    ])
                    ->fields([
                        'print_size_id' => Select::make()->fromModel(PrintSize::class, 'name', 'id'),
                        'pixels_w' => Input::make()
                            ->type('number')
                            ->min(0)
                            ->step('0.01'),
                        'pixels_h' => Input::make()
                            ->type('number')
                            ->min(0)
                            ->step('0.01'),
                    ]),
            ])
                ->title('Соотношения стандартных размеров печати к пикселям')
                ->canSee($this->query->get('parameters_type') === 'changeable'),
        ];
    }
}
