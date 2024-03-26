<?php

declare(strict_types=1);

namespace Wnx\Sends\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Str;

class AttachSendUuidListener
{
    public function handle(MessageSending $event): void
    {
        /** @var string $sendUuidHeader */
        $sendUuidHeader = config('sends.headers.send_uuid');

        if ($event->message->getHeaders()->has($sendUuidHeader)) {
            return;
        }

        $event->message->getHeaders()->addTextHeader($sendUuidHeader, Str::uuid()->toString());
    }
}
