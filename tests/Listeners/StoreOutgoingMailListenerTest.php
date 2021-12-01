<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use Wnx\Sends\Tests\TestSupport\Mails\TestMail;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithMailClassHeader;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithPublicProperties;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithRelatedModelsHeader;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithRelatedModelsHeaderAndPublicProperties;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithRelatedModelsHeaderWrongModel;
use Wnx\Sends\Tests\TestSupport\Models\TestModel;
use Wnx\Sends\Tests\TestSupport\Models\TestModelWithoutHasSendsContract;
use Wnx\Sends\Tests\TestSupport\Notifications\TestNotification;

it('stores outgoing mails in database table', function () {
    Mail::to('test@example.com')
        ->send(new TestMail());

    assertDatabaseHas('sends', [
        'message_id' => null,
        'mail_class' => null,
        'subject' => '::subject::',
        'to' => json_encode(['test@example.com' => null]),
        'cc' => null,
        'bcc' => null,
        'sent_at' => now(),
    ]);

    assertDatabaseCount('sendables', 0);
});

it('stores to cc and bcc addresses in database table', function () {
    Mail::to('test@example.com')
        ->cc([
            'cc-1@example.com',
            [
                'email' => 'cc-2@example.com',
                'name' => 'CC Name 2',
            ],
        ])
        ->bcc([
            'bcc-1@example.com',
            [
                'email' => 'bcc-2@example.com',
                'name' => 'BCC Name 2',
            ],
        ])
        ->send(new TestMail());

    assertDatabaseHas('sends', [
        'mail_class' => null,
        'subject' => '::subject::',
        'to' => json_encode(['test@example.com' => null]),
        'cc' => json_encode([
            'cc-1@example.com' => null,
            'cc-2@example.com' => 'CC Name 2',
        ]),
        'bcc' => json_encode([
            'bcc-1@example.com' => null,
            'bcc-2@example.com' => 'BCC Name 2',
        ]),
        'sent_at' => now(),
    ]);
});

it('stores transport message id in database table', function () {
    $this->addTransportMessageIdHeaderToMail();

    Mail::to('test@example.com')
        ->send(new TestMail());

    assertDatabaseHas('sends', [
        ['message_id', '!=', null],
        'mail_class' => null,
        'subject' => '::subject::',
    ]);
});

it('stores fqn of mail class in database table', function () {
    Mail::to('test@example.com')
        ->send(new TestMailWithMailClassHeader());

    assertDatabaseHas('sends', [
        'mail_class' => TestMailWithMailClassHeader::class,
        'subject' => '::subject::',
        'to' => json_encode(['test@example.com' => null]),
        'cc' => null,
        'bcc' => null,
        'sent_at' => now(),
    ]);
});

it('attaches related models to a send model if respective header is present', function () {
    $testModel = TestModel::create();

    Mail::to('test@example.com')
        ->send(new TestMailWithRelatedModelsHeader($testModel));

    assertDatabaseHas('sends', [
        'mail_class' => null,
        'subject' => '::subject::',
        'to' => json_encode(['test@example.com' => null]),
        'cc' => null,
        'bcc' => null,
        'sent_at' => now(),
    ]);
    assertDatabaseHas('sendables', [
        'send_id' => 1,
        'sendable_type' => TestModel::class,
        'sendable_id' => 1,
    ]);
});

it('attaches related models to a send model based on the public properties of the mail class', function () {
    $testModel = TestModel::create();

    Mail::to('test@example.com')
        ->send(new TestMailWithPublicProperties($testModel));

    assertDatabaseHas('sends', [
        'mail_class' => null,
        'subject' => '::subject::',
        'to' => json_encode(['test@example.com' => null]),
        'cc' => null,
        'bcc' => null,
        'sent_at' => now(),
    ]);
    assertDatabaseHas('sendables', [
        'send_id' => 1,
        'sendable_type' => TestModel::class,
        'sendable_id' => 1,
    ]);
});

it('attaches related models only once if related models are defined both as public properties and through the method', function () {
    $testModel = TestModel::create();

    Mail::to('test@example.com')
        ->send(new TestMailWithRelatedModelsHeaderAndPublicProperties($testModel));

    assertDatabaseHas('sends', [
        'mail_class' => null,
        'subject' => '::subject::',
        'to' => json_encode(['test@example.com' => null]),
        'cc' => null,
        'bcc' => null,
        'sent_at' => now(),
    ]);
    assertDatabaseCount('sendables', 1);
    assertDatabaseHas('sendables', [
        'send_id' => 1,
        'sendable_type' => TestModel::class,
        'sendable_id' => 1,
    ]);
});

it('throws type error if related model does not implement HasSends contract', function () {
    expect(function () {
        $testModel = TestModelWithoutHasSendsContract::create();
        Mail::to('test@example.com')
            ->send(new TestMailWithRelatedModelsHeaderWrongModel($testModel));
    })->toThrow(TypeError::class);

    assertDatabaseCount('sends', 0);
    assertDatabaseCount('sendables', 0);
    assertDatabaseMissing('sendables', [
        'send_id' => 1,
        'sendable_type' => TestModelWithoutHasSendsContract::class,
        'sendable_id' => 1,
    ]);
});

it('stores outgoing notifications in database table', function () {
    $testModel = TestModel::create();

    Notification::route('mail', 'foo@example.com')
        ->notify(new TestNotification($testModel));

    assertDatabaseHas('sends', [
        'message_id' => null,
        'mail_class' => null,
        'subject' => '::subject-of-notification::',
        'to' => json_encode(['foo@example.com' => null]),
        'cc' => null,
        'bcc' => null,
        'sent_at' => now(),
    ]);
});
