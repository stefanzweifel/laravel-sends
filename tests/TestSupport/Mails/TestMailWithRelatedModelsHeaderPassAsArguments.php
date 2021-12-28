<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Wnx\Sends\Support\StoreMailables;
use Wnx\Sends\Tests\TestSupport\Models\AnotherTestModel;
use Wnx\Sends\Tests\TestSupport\Models\TestModel;

class TestMailWithRelatedModelsHeaderPassAsArguments extends Mailable
{
    use StoreMailables;
    use SerializesModels;

    public function __construct(private TestModel $testModel, private AnotherTestModel $anotherTestModel)
    {
    }

    public function build()
    {
        return $this
            ->associateWith($this->testModel, $this->anotherTestModel)
            ->view('emails.test')
            ->subject("::subject::");
    }
}
