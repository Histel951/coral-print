<?php

namespace App\Orchid\Screens\Preview;

use App\Events\PreviewCacheClearEvent;
use App\Models\Calculator;
use App\Models\Preview;
use App\Orchid\Fields\SvgIdPicture;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Preview\PreviewListener;

class PreviewEditScreen extends EditScreen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Preview $preview): iterable
    {
        return [
            'preview' => $preview,
            'image' => $preview->image,
            'calculator_id' => $preview->calculator_id,
            'parameters_type' => $this->getParametersType($preview->calculator),
            'width' => $preview->width,
            'height' => $preview->height,
            'coefficient_w' => $preview->coefficient_w ?? 0,
            'coefficient_h' => $preview->coefficient_h ?? 0,
            'description' => $preview->description,
            'sequence' => $preview->sequence,
            'dependence' => $preview->dependence,
            'print_size_id' => $preview->print_size_id,
            'form_id' => $preview->form_id,
            'cutting_id' => $preview->cutting_id,
            'bracer_id' => $preview->bracer?->id,
            'pixels_sizes' => $preview->previewPrintSizePixels->toArray(),
            'svg_id' => $preview->svg_id,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование превью';
    }

    private function getParametersType(Calculator $calculator): string
    {
        $type = $calculator->calculatorType->previewOptions?->parameters_type;

        if (!$type) {
            $type = 'default';
        }

        return $type;
    }

    public function asyncFields(
        Calculator $calculator,
        float|null $width,
        float|null $height,
        string|null $description,
        int|null $sequence,
        string|null $dependence,
        int|null $bracer_id,
        mixed $pixels_sizes,
    ): array {
        if ($width && $height) {
            $coefficientW = $width / $height;
            $coefficientH = $height / $width;
        } else {
            $coefficientW = 0;
            $coefficientH = 0;
        }

        return [
            'calculator_id' => $calculator->id,
            'coefficient_w' => $coefficientW,
            'coefficient_h' => $coefficientH,
            'width' => $width,
            'height' => $height,
            'description' => $description,
            'sequence' => $sequence,
            'dependence' => $dependence,
            'bracer_id' => $bracer_id,
            'parameters_type' => $this->getParametersType($calculator),
            'pixels_sizes' => $pixels_sizes,
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
            Layout::rows([
                SvgIdPicture::make('svg_id')->title('ID svg картинки превью:'),

                Select::make('calculator_id')
                    ->fromModel(Calculator::class, 'name', 'id')
                    ->title('Калькулятор')
                    ->empty('Не выбрано')
                    ->required(),
            ]),
            PreviewListener::class,
        ];
    }

    public function edit(Request $request, Preview $preview): void
    {
        $data = $request->all();

        $height = (float) $request->get('height', 0);
        $width = (float) $request->get('width', 0);

        if ($height && $width) {
            $data['coefficient_h'] = $height / $width;
            $data['coefficient_w'] = $width / $height;
        } else {
            $data['coefficient_h'] = 0;
            $data['coefficient_w'] = 0;
        }

        if ($preview->fill($data)->save()) {
            event(new PreviewCacheClearEvent());

            Alert::success('Превью обновлено!');
        } else {
            Alert::success('Превью не обновлено.');
        }
    }

    public function delete(Preview $preview): RedirectResponse
    {
        $preview->delete();

        Alert::success('Превью успешно удалено.');

        return redirect()->route('platform.previews');
    }
}
