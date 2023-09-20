<?php

namespace App\Mail;

use App\Models\MailTemplate;
use App\Models\Promocode;
use App\Services\SendMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromocodeInstructionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(
        private readonly Promocode $promocode,
        private readonly SendMailService $sendMailService,
    ) {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = MailTemplate::query()
            ->where('type', 'promocode')
            ->get()
            ->first();
        return $this->from('info@corall-print.ru', 'Промокод Corall Print')
            ->view('mails.promocode_instruction', [
                'html' => $this->sendMailService->getPromocodeMailHtml($this->promocode, $template),
            ])
            ->subject($template->name);
    }
}
