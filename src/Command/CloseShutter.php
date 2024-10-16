<?php

namespace App\Command;

use App\Dto\Shutter;

class CloseShutter
{
    public function __construct(
        public readonly Shutter $shutter
    ) {
    }
}
