<?php

namespace App\Orchid\Screens\Pages;

use App\Models\Pages\Block;
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

class BlockEditScreen extends Screen
{
    public Block $block;

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
                'block' => Block::find($id),
            ];
        }

        return [
            'block' => Block::make(),
        ];
    }

    public function name(): ?string
    {
        return $this->block->id ? 'Редактирование блока' : 'Создание блока';
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
                ->method('saveBlock', ['id' => $this->block->id ?? null])
                ->type(Color::SUCCESS())
                ->icon('cursor'),

            Button::make('Delete')
                ->method('deleteBlock', ['id' => $this->block->id])
                ->icon('cross')
                ->type(Color::DANGER())
                ->canSee(boolval($this->block->id))
                ->confirm('Вы хотите удалить блок?'),
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
                Input::make('block.alias')
                    ->title('Алиас')
                    ->autocomplete(false)
                    ->required()
                    ->validationRule(Rule::unique('blocks', 'name')),

                Code::make('block.content')
                    ->title('Шаблон')
                    ->required()
                    ->language('html'),
            ]),
        ];
    }

    /**
     * @param int|null $id
     *
     * @return RedirectResponse
     */
    public function saveBlock(?int $id): RedirectResponse
    {
        $data = request()->all();

        try {
            if (null !== $id) {
                $block = Block::find($id);
                $block->update($data['block']);
            } else {
                Block::create($data['block']);
            }

            Toast::success(HAlert::SUCCESS_MSG);
        } catch (\Exception $e) {
            Toast::error(HAlert::ERROR_MSG);
        }

        return redirect()->route('platform.blocks');
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function deleteBlock(int $id): RedirectResponse
    {
        $block = Block::find($id);
        $block->delete();

        Toast::success(HAlert::SUCCESS_MSG);

        return redirect()->route('platform.blocks');
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'block.id' => 'int',
            'block.alias' => 'required|string|unique:blocks',
            'block.content' => 'required|string',
        ];
    }
}
