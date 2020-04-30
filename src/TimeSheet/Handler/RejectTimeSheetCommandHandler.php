<?php
declare(strict_types=1);

namespace App\TimeSheet\Handler;

use App\Shared\Exception\NotAuthorizedException;
use App\Shared\Services\EventPersister;
use App\TimeSheet\Command\RejectTimeSheetCommand;
use App\TimeSheet\Events\TimeSheetRejected;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RejectTimeSheetCommandHandler implements MessageHandlerInterface
{
    /** @var EventPersister */
    private $eventPersister;

    public function __construct(EventPersister $eventPersister)
    {
        $this->eventPersister = $eventPersister;
    }

    /**
     * @param RejectTimeSheetCommand $command
     *
     * @throws NotAuthorizedException
     */
    public function __invoke(RejectTimeSheetCommand $command): void
    {
        //Simulate permission denied. 50/50 chance.
        if ((int)$command->getUserId() % 2 === 0) {
            throw new NotAuthorizedException();
        }

        $this->eventPersister->persistEvent(
            new TimeSheetRejected($command->getUserId(), $command->getTimeSheetId(), $command->getReason())
        );
    }
}
