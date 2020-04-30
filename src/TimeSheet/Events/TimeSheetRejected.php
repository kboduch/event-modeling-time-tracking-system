<?php
declare(strict_types=1);

namespace App\TimeSheet\Events;

use App\Shared\Events\EventInterface;

final class TimeSheetRejected implements EventInterface
{
    /** @var string */
    private $userId;

    /** @var string */
    private $timeSheetId;

    /** @var null|string */
    private $reason;

    public function __construct(string $userId, string $timeSheetId, ?string $reason)
    {
        $this->userId = $userId;
        $this->timeSheetId = $timeSheetId;
        $this->reason = $reason;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getTimeSheetId(): string
    {
        return $this->timeSheetId;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }
}
