<?php
declare(strict_types=1);

namespace App\Shared\Services;

use App\Shared\Events\EventInterface;
use App\TimeSheet\Events\TimeSheetRejected;
use DateTime;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

final class EventPersister
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var Filesystem */
    private $filesystem;

    /** @var string */
    private $eventFolderPath;

    public function __construct(SerializerInterface $serializer, Filesystem $filesystem, string $eventFolderPath)
    {
        $this->serializer = $serializer;
        $this->filesystem = $filesystem;
        $eventFolderPath = rtrim($eventFolderPath, DIRECTORY_SEPARATOR);

        if (!$filesystem->exists($eventFolderPath)) {
            throw new RuntimeException(sprintf('Given event folder path ("%s") does not exist.', $eventFolderPath));
        }

        $this->eventFolderPath = $eventFolderPath;
    }

    public function persistEvent(EventInterface $event): void
    {
        $serializedEvent = $this->serializer->serialize($event, 'json');

        $this->filesystem->dumpFile(
            sprintf(
                '%s%s.json',
                $this->eventFolderPath . DIRECTORY_SEPARATOR,
                trim(
                    $this->getEventLocation($event) . DIRECTORY_SEPARATOR . $this->getEventFilename($event),
                    DIRECTORY_SEPARATOR
                )
            ),
            $serializedEvent
        );
    }

    private function getEventLocation(EventInterface $event): string
    {
        switch (get_class($event)) {
            default:
                return '';
                break;
        }
    }

    private function getEventFilename(EventInterface $event): string
    {
        switch (get_class($event)) {
            case TimeSheetRejected::class:
                /** @var $event TimeSheetRejected */
                return sprintf(
                    '%s-TimeSheetRejected-%s',
                    (new DateTime())->format(DateTime::ATOM),
                    $event->getTimeSheetId()
                );
                break;
            default:
                throw new RuntimeException('Missing event filename definition for ' . get_class($event));
                break;
        }
    }
}
