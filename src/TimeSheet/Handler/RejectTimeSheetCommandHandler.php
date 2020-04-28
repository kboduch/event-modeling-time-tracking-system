<?php
declare(strict_types=1);

namespace App\TimeSheet\Handler;

use App\TimeSheet\Command\RejectTimeSheetCommand;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RejectTimeSheetCommandHandler implements MessageHandlerInterface
{
    public function __invoke(RejectTimeSheetCommand $command): void
    {
        //todo
    }
}
