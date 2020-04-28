<?php
declare(strict_types=1);

namespace App\TimeSheet\Events;

use App\Shared\Events\EventInterface;

final class TimeSheetRejected implements EventInterface
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

    public function serialize()
    {
        return json_encode(
            [
                'timeSheetId' => $this->timeSheetId,
                'reason' => $this->reason,
            ]
        );
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized, true);

        //to keep it simple...
        $this->timeSheetId = $data['timeSheetId'] ?: '';
        $this->reason = $data['reason'] ?: '';
    }
}
