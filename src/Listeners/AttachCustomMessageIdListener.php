<?php

declare(strict_types=1);

namespace Wnx\Sends\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Str;

class AttachCustomMessageIdListener
{
    public function handle(MessageSending $event): void
    {
        if ($event->message->getHeaders()->has(config('sends.headers.custom_message_id'))) {
            return;
        }

        $event->message->getHeaders()->addTextHeader(config('sends.headers.custom_message_id'), Str::uuid()->toString());
    }
}
