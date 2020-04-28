<?php
declare(strict_types=1);

namespace App\TimeSheet\Command;

final class RejectTimeSheetCommand
{
    /** @var string */
    private $timeSheetId;

    /** @var string */
    private $reason;

    public function __construct(string $timeSheetId, string $reason)
    {
        $this->timeSheetId = $timeSheetId;
        $this->reason = $reason;
    }

    public function getTimeSheetId(): string
    {
        return $this->timeSheetId;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
