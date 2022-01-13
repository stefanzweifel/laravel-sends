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
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithRelatedModelsHeaderPassAsArguments;
use Wnx\Sends\Tests\TestSupport\Mails\TestMailWithRelatedModelsHeaderWrongModel;
use Wnx\Sends\Tests\TestSupport\Models\AnotherTestModel;
use Wnx\Sends\Tests\TestSupport\Models\TestModel;
use Wnx\Sends\Tests\TestSupport\Models\TestModelWithoutHasSendsContract;
use Wnx\Sends\Tests\TestSupport\Notifications\TestNotification;

it('stores outgoing mails in database table', function () {
    Mail::to([
        [
            'email' => 'to-1@example.com',
            'name' => 'To 1 Name',
        ],
        'to-2@example.com',
    ])
        ->send(new TestMail());

    assertDatabaseHas('sends', [
        'uuid' => null,
        'mail_class' => null,
        'subject' => '::subject::',
        'to' => json_encode([
            'to-1@example.com' => 'To 1 Name',
            'to-2@example.com' => null,
        ]),
        'cc' => null,
        'bcc' => null,
        ['sent_at', '!=', null],
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
        'from' => json_encode(['from@example.com' => 'From']),
        'reply_to' => json_encode(['reply@example.com' => 'Reply']),
        'to' => json_encode(['test@example.com' => null]),
        'cc' => json_encode([
            'cc-1@example.com' => null,
            'cc-2@example.com' => 'CC Name 2',
        ]),
        'bcc' => json_encode([
            'bcc-1@example.com' => null,
            'bcc-2@example.com' => 'BCC Name 2',
        ]),
        ['sent_at', '!=', null],
    ]);
});

it('stores send uuid in database table', function () {
    $this->addSendUuidHeaderToMail();

    Mail::to('test@example.com')
        ->send(new TestMail());

    assertDatabaseHas('sends', [
        ['uuid', '!=', null],
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
        ['sent_at', '!=', null],
    ]);
});

it('attaches related models to a send model if respective header is present', function () {
    $testModel = TestModel::create();

    Mail::to('test@example.com')
        ->send(new TestMailWithRelatedModelsHeader($testModel));

    assertDatabaseHas('sends', [
        'mail_class' => null,
        'subject' => '::subject::',
        ['sent_at', '!=', null],
    ]);
    assertDatabaseHas('sendables', [
        'send_id' => 1,
        'sendable_type' => TestModel::class,
        'sendable_id' => 1,
    ]);
});

it('attaches related models to a send model by passing arguments to associateWith method', function () {
    $testModel = TestModel::create();
    $anotherTestModel = AnotherTestModel::create();

    Mail::to('test@example.com')
        ->send(new TestMailWithRelatedModelsHeaderPassAsArguments($testModel, $anotherTestModel));

    assertDatabaseHas('sends', [
        'mail_class' => null,
        'subject' => '::subject::',
        ['sent_at', '!=', null],
    ]);
    assertDatabaseHas('sendables', [
        'send_id' => 1,
        'sendable_type' => TestModel::class,
        'sendable_id' => 1,
    ]);
    assertDatabaseHas('sendables', [
        'send_id' => 1,
        'sendable_type' => AnotherTestModel::class,
        'sendable_id' => 2,
    ]);
});

it('attaches related models to a send model based on the public properties of the mail class', function () {
    $testModel = TestModel::create();

    Mail::to('test@example.com')
        ->send(new TestMailWithPublicProperties($testModel));

    assertDatabaseHas('sends', [
        'mail_class' => null,
        'subject' => '::subject::',
        ['sent_at', '!=', null],
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
        ['sent_at', '!=', null],
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
        'uuid' => null,
        'mail_class' => null,
        'subject' => '::subject-of-notification::',
        'to' => json_encode(['foo@example.com' => null]),
        ['sent_at', '!=', null],
    ]);
});

it('does not store content of outgoing mail in database table if config is set to false', function () {
    config(['sends.store_content' => false]);

    Mail::to('test@example.com')
        ->send(new TestMail());

    assertDatabaseHas('sends', [
        'content' => null,
    ]);

    assertDatabaseCount('sendables', 0);
});

it('stores content of outgoing mail in database table if config is set to true', function () {
    config(['sends.store_content' => true]);

    Mail::to('test@example.com')
        ->send(new TestMail());

    assertDatabaseHas('sends', [
        'content' => "<h1>Test</h1>\n\n<p>This is a test mail.</p>\n",
    ]);

    assertDatabaseCount('sendables', 0);
});
