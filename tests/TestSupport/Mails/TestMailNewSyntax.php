<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMailNewSyntax extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function envelope()
    {
        return new Envelope(
            from: new Address(address: 'from@example.com', name: 'From'),
            replyTo: [new Address(address: 'reply@example.com', name: 'Reply')],
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
}
