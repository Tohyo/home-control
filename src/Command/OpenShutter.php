<?php

namespace App\Command;

use App\Dto\Shutter;

class OpenShutter
{
    public function __construct(
        public readonly Shutter $shutter
    ) {
    }
}
