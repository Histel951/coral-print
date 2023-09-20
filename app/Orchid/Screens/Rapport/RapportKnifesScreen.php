<?php

namespace App\Orchid\Screens\Rapport;

use App\Models\Rapport;
use App\Models\RapportKnife;
use App\Orchid\Helpers\HAlert;
use App\Orchid\Layouts\Flex\Rapport\RapportKnifeSelection;
use App\Services\RapportKnifeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\Rapport\RapportKnifesLayout;
use Orchid\Support\Facades\Layout;

class RapportKnifesScreen extends Screen
{
    public Rapport $rapport;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Rapport $rapport): iterable
    {
        return [
            'rapport' => $rapport,
            'rapportKnifes' => RapportKnife::with(['rapport', 'printForm'])
                ->where('rapport_id', $rapport->id)
                ->filtersApplySelection(RapportKnifeSelection::class)
                ->filters()
                ->defaultSort('id', 'desc')
                ->get(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Ножи вал-{$this->rapport->name}";
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('confirmDeleteRapportKnife', [
                Layout::rows([])->title('Вы уверены, что хотите безвозвратно удалить запись?')
            ])->applyButton('Да')->closeButton('Нет'),

            Layout::modal('confirmAddKnifeNumber', [
                Layout::rows([])->title('Вы хотите создать номер ножа?')
            ])->applyButton('Да')->closeButton('Нет'),

            RapportKnifeSelection::class,
            RapportKnifesLayout::class
        ];
    }

    public function addNewRapportKnife(Request $request): Response
    {
        $layout = new RapportKnifesLayout();
        $newRapportKnife = RapportKnife::create([
            'rapport_id' => $request->input('rapport_id'),
        ]);

        $rapportKnife = RapportKnife::with([
            'printForm',
            'rapport',
            'image',
            'imageSmall'
        ])->find($newRapportKnife->getKey());

        return \response()->view(
            'orchid.turbo.turbo-stream-tr-item-add',
            [
                'source' => $rapportKnife,
                'columns' => $layout->getColumns(),
                'action' => 'prepend'
            ],
            headers: [
                'Content-Type' => 'text/vnd.turbo-stream.html',
            ],
        );
    }

    /**
     * Создаёт номер ножа
     * @param Request $request
     * @param RapportKnifeServiceInterface $rapportKnifeService
     * @return void
     */
    public function createKnife(Request $request, RapportKnifeServiceInterface $rapportKnifeService): void
    {
        $rapportKnifeService->createRapportKnifeNumber((int)$request->input('knife'));
    }

    public function deleteRapportKnife(Request $request): void
    {
        HAlert::alert(RapportKnife::find($request->get('id'))->delete());
    }

    /**
     * Удаляет номер ножа
     * @param Request $request
     * @param RapportKnifeServiceInterface $rapportKnifeService
     * @return void
     */
    public function removeKnife(Request $request, RapportKnifeServiceInterface $rapportKnifeService): void
    {
        $rapportKnifeService->removeRapportKnifeNumber((int)$request->input('knife'));
    }

    public function changeKnifeField(Request $request): Response
    {
        RapportKnife::find($request->get('id'))->update([
            $request->input('field') => $request->input('content'),
        ]);

        return \response('', 204);
    }
}
