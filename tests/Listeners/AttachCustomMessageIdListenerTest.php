<?php

declare(strict_types=1);

use Illuminate\Mail\Events\MessageSending;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;
use Wnx\Sends\Listeners\AttachCustomMessageIdListener;

it('attaches send uuid header', function () {
    $event = new MessageSending(new Swift_Message());

    (new AttachCustomMessageIdListener())->handle($event);

    assertTrue($event->message->getHeaders()->has('X-Laravel-Send-UUID'));
    assertTrue($event->message->getHeaders()->has(config('sends.headers.send_uuid')));
    assertNotNull($event->message->getHeaders()->get(config('sends.headers.send_uuid')));
});
