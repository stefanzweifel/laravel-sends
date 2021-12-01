<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Wnx\Sends\Contracts\HasSends;
use Wnx\Sends\Support\HasSendsTrait;

class TestModel extends Model implements HasSends
{
    use HasSendsTrait;
}
