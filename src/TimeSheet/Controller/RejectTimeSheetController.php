<?php
declare(strict_types=1);

namespace App\TimeSheet\Controller;

use App\TimeSheet\CommandFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class RejectTimeSheetController
{
    /** @var CommandFactory */
    private $commandFactory;

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(CommandFactory $commandFactory, MessageBusInterface $commandBus)
    {
        $this->commandFactory = $commandFactory;
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        //todo handle exception
        $command = $this->commandFactory->createRejectTimeSheetCommandFromRequest($request);
        $this->commandBus->dispatch(new Envelope($command));

        return new Response();
    }
}
