<?php

namespace App\Orchid\Screens\Pages;

use App\Models\Pages\PageTemplate;
use App\Orchid\Helpers\HAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TemplateEditScreen extends Screen
{
    public PageTemplate $pageTemplate;

    /**
     * Query data.
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function query(): array
    {
        $id = request()->get('id');

        if ($id) {
            return [
                'pageTemplate' => PageTemplate::find($id),
            ];
        }

        return [
            'pageTemplate' => PageTemplate::make(),
        ];
    }

    public function name(): ?string
    {
        return $this->pageTemplate->id ? 'Редактирование шаблона' : 'Создание шаблона';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->method('savePageTemplate', ['id' => $this->pageTemplate->id ?? null])
                ->type(Color::SUCCESS())
                ->icon('cursor'),

            Button::make('Delete')
                ->method('deletePageTemplate', ['id' => $this->pageTemplate->id])
                ->icon('cross')
                ->type(Color::DANGER())
                ->canSee(boolval($this->pageTemplate->id))
                ->confirm('Вы хотите удалить шаблон?'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('pageTemplate.name')
                    ->title('Название')
                    ->autocomplete(false)
                    ->required(),

                Input::make('pageTemplate.alias')
                    ->title('Алиас')
                    ->autocomplete(false)
                    ->required()
                    ->validationRule(Rule::unique('page_templates', 'alias')),

                Code::make('pageTemplate.template')
                    ->title('Шаблон')
                    ->required()
                    ->language('blade'),
            ]),
        ];
    }

    /**
     * @param int|null $id
     *
     * @return RedirectResponse
     */
    public function savePageTemplate(?int $id): RedirectResponse
    {
        $data = request()->all();

        try {
            if (null !== $id) {
                $pageTemplate = PageTemplate::find($id);
                $pageTemplate->update($data['pageTemplate']);
            } else {
                PageTemplate::create($data['pageTemplate']);
            }

            Toast::success(HAlert::SUCCESS_MSG);
        } catch (\Exception $e) {
            Toast::error(HAlert::ERROR_MSG);
        }

        return redirect()->route('platform.templates');
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function deletePageTemplate(int $id): RedirectResponse
    {
        try {
            $pageTemplate = PageTemplate::find($id);
            $pageTemplate->delete();

            Toast::success(HAlert::SUCCESS_MSG);
        } catch (\Exception $e) {
            Toast::error(HAlert::ERROR_MSG);
        }

        return redirect()->route('platform.templates');
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'pageTemplate.id' => 'int',
            'pageTemplate.name' => 'required|string',
            'pageTemplate.alias' => 'required|string|unique:page_templates',
            'pageTemplate.template' => 'required|string',
        ];
    }
}
