<?php

namespace App\Controller;

use App\HomeAutomation\AutomationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shutters', name: self::class)]
class ListShuttersController extends AbstractController
{
    public function __construct(
        private AutomationInterface $automation
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render('list_shutters/index.html.twig', [
            'shutters' => $this->automation->listShutters()
        ]);
    }
}
