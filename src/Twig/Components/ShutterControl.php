<?php

namespace App\Twig\Components;

use App\Command\CloseShutter;
use App\Command\OpenShutter;
use App\Dto\Shutter;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ShutterControl
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $id;

    #[LiveProp(writable: true)]
    public string $label;

    #[LiveProp(writable: true)]
    public int $siteId;

    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    #[LiveAction]
    public function closeShutter(): void
    {
        $this->messageBus->dispatch(new CloseShutter(new Shutter($this->id, $this->label, $this->siteId)));
    }

    #[LiveAction]
    public function openShutter(): void
    {
        $this->messageBus->dispatch(new OpenShutter(new Shutter($this->id, $this->label, $this->siteId)));
    }
}
