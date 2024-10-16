<?php

namespace App\Command;

use App\HomeAutomation\AutomationInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class OpenShutterCommand
{
    public function __construct(
        private AutomationInterface $automation
    ) {
    }

    public function __invoke(OpenShutter $openShutter)
    {
        $this->automation->openShutter($openShutter->shutter);
    }
}
