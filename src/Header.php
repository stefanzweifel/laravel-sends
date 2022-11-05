<?php

declare(strict_types=1);

namespace Wnx\Sends;

use Symfony\Component\Mime\Header\UnstructuredHeader;

class Header extends UnstructuredHeader
{
    public function toArray(): array
    {
        return [
            $this->getName() => $this->getValue(),
        ];
    }
}
