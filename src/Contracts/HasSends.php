<?php

declare(strict_types=1);

namespace Wnx\Sends\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface HasSends
{
    public function sends(): MorphToMany;
}
