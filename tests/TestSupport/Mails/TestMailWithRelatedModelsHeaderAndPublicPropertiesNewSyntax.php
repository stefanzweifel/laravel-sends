<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Wnx\Sends\Support\StoreMailables;
use Wnx\Sends\Tests\TestSupport\Models\TestModel;

class TestMailWithRelatedModelsHeaderAndPublicPropertiesNewSyntax extends Mailable
{
    use Queueable;
    use SerializesModels;
    use StoreMailables;

    public function __construct(public TestModel $testModel)
    {
    }

    /**
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '::subject::',
        );
    }

    /**
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.test',
        );
    }

    /**
     * Get the message headers.
     *
     * @return \Illuminate\Mail\Mailables\Headers
     */
    public function headers()
    {
        return new Headers(
            text: array_merge(
                ['X-Custom-Header' => 'Custom Value'],
                $this->getAssociateWithHeader([$this->testModel]),
            ),
        );
    }
}
