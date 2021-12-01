<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Model;

class TestModelWithoutHasSendsContract extends Model
{
    protected $table = 'test_models';
}
