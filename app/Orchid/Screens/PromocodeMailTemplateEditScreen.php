<?php

namespace App\Orchid\Screens;

use App\Models\MailTemplate;
use App\Orchid\Helpers\HAlert;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PromocodeMailTemplateEditScreen extends EditScreen
{
    public MailTemplate $mailTemplate;

    public function __construct(MailTemplate $mailTemplate)
    {
        $this->mailTemplate =
            MailTemplate::where('type', 'promocode')
                ->get()
                ->first() ?? $mailTemplate;
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'mailTemplate' => $this->mailTemplate,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Шаблон e-mail';
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
                Input::make('mailTemplate.name')->title('Тема'),
                TextArea::make('mailTemplate.template')
                    ->title('HTML шаблон:')
                    ->rows(20),
            ]),
        ];
    }

    public function edit(Request $request)
    {
        $this->mailTemplate->type = 'promocode';
        $this->mailTemplate->fill($request->get('mailTemplate'));
        if ($this->mailTemplate->save()) {
            Toast::success(HAlert::SUCCESS_MSG);

            return redirect()->route('platform.promocodes.template');
        } else {
            Toast::success(HAlert::ERROR_MSG);
        }
    }

    public function delete(MailTemplate $mailTemplate)
    {
        $success = $mailTemplate->delete();
        HAlert::alert($success);

        return redirect()->route('platform.promocodes.template');
    }
}
