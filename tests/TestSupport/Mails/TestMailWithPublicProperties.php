<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Wnx\Sends\Support\StoreMailables;
use Wnx\Sends\Tests\TestSupport\Models\TestModel;

class TestMailWithPublicProperties extends Mailable
{
    use StoreMailables;
    use SerializesModels;

    public function __construct(public TestModel $testModel)
    {
    }

    public function build()
    {
        return $this
            ->associateWith()
            ->view('emails.test')
            ->subject("::subject::");
    }
}
