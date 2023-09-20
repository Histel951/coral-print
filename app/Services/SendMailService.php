<?php

namespace App\Services;

use App\Mail\PromocodeInstructionMail;
use App\Models\MailTemplate;
use App\Models\Promocode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

final class SendMailService
{
    public function sendPromocodeMessage(Promocode $model, string $email): void
    {
        try {
            Mail::to($email)->send(new PromocodeInstructionMail($model, $this));
        } catch (\Exception $e) {
        }
    }

    public function getPromocodeMailHtml(Promocode $promocode, MailTemplate $mailTemplate): string
    {
        return Str::replace(
            '{{$promocode->discount}}',
            $promocode->discount,
            Str::replace('{{$promocode->name}}', $promocode->value, $mailTemplate->template),
        );
    }
}
