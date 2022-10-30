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

class TestMailWithMailClassHeaderNewSyntax extends Mailable
{
    use Queueable;
    use SerializesModels;
    use StoreMailables;

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
                ['X-Custom-Header' => 'Custom Value',],
                // storeClassName
                // $this->storeClassName()->headers->all()
            ),
        );
    }
}
