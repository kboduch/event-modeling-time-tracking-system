<?php
declare(strict_types=1);

namespace App\Shared\Services;

use App\Shared\Events\EventInterface;
use Symfony\Component\Filesystem\Filesystem;

final class EventPersister
{
    /** @var Filesystem */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function persistEvent(EventInterface $event): void
    {

    }
}
