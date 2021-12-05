<?php

declare(strict_types=1);

use function PHPUnit\Framework\assertTrue;
use Wnx\Sends\Models\Send;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithMailClassHeader;

it('finds send model by given message id', function () {

    /** @var Send $send */
    $send = Send::factory()->create();

    /** @var Send $result */
    $result = Send::forMessageId($send->message_id)->first();

    assertTrue($result->is($send));
});

it('finds send model by given model class fqn', function () {
    /** @var Send $send */
    $send = Send::factory()->create([
        'mail_class' => TestMailWithMailClassHeader::class,
    ]);

    /** @var Send $result */
    $result = Send::forMailClass($send->mail_class)->first();

    assertTrue($result->is($send));
});
