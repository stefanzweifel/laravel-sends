<?php

declare(strict_types=1);

namespace Wnx\Sends\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Str;

class AttachSendUuidListener
{
    public function handle(MessageSending $event): void
    {
        if ($event->message->getHeaders()->has(config('sends.headers.send_uuid'))) {
            return;
        }

        $event->message->getHeaders()->addTextHeader(config('sends.headers.send_uuid'), Str::uuid()->toString());
    }
}
