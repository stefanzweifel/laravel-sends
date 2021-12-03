<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Wnx\Sends\Support\StoreMailables;

class TestMail extends Mailable
{
    use StoreMailables;
    use SerializesModels;

    public function build()
    {
        return $this
            ->replyTo('reply@example.com', 'Reply')
            ->from('from@example.com', 'From')
            ->view('emails.test')
            ->subject("::subject::");
    }
}
