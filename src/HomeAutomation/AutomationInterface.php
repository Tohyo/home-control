<?php

namespace App\HomeAutomation;

use App\Dto\Shutter;

interface AutomationInterface
{
    public function listShutters(): array;
    public function closeShutter(Shutter $shutter): void;
    public function openShutter(Shutter $shutter): void;
}
