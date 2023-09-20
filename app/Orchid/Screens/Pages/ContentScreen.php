<?php

namespace App\Orchid\Screens\Pages;

use App\Models\Content;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class ContentScreen extends Screen
{
    public function __construct(
        protected ContentService $contentService
    ) {
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Контент';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать')
                ->method('editContent')
                ->icon('new-doc')
                ->type(Color::PRIMARY()),
        ];
    }

    /**
     * Views.
     *
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Group::make([
                    Select::make('find_id')
                        ->title('Поиск')
                        ->fromModel(Content::class, 'title', 'content_id'),

                    Button::make('Редактировать')
                        ->method('findContent')
                        ->icon('note')
                        ->type(Color::INFO()),
                ])->alignStart(),
            ]),

            Layout::view('content', [
                'data' => $this->contentService->getContentTree(),
            ]),
        ];
    }

    public function findContent(Request $request)
    {
        return redirect()->route('platform.content.edit', ['content_id' => $request->get('find_id')]);
    }

    public function editContent(Request $request)
    {
        return redirect()->route('platform.content.edit', ['content_id' => $request->get('content_id')]);
    }
}
