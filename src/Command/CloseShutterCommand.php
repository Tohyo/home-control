<?php

namespace App\Command;

use App\HomeAutomation\AutomationInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CloseShutterCommand 
{
    public function __construct(
        private AutomationInterface $automation
    ) {
    }

    public function __invoke(CloseShutter $closeShutter)
    {
        $this->automation->closeShutter($closeShutter->shutter);
    }
}