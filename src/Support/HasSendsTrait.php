<?php

declare(strict_types=1);

namespace Wnx\Sends\Support;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Wnx\Sends\Models\Send;

trait HasSendsTrait
{
    public function sends(): MorphToMany
    {
        return $this
            ->morphToMany(Send::class, 'sendable')
            ->orderByDesc('id');
    }
}
