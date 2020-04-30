<?php
declare(strict_types=1);

namespace App\Shared\Exception;

use RuntimeException;
use Throwable;

final class NotAuthorizedException extends RuntimeException
{
    public function __construct($message = 'You are not authorized to perform this action.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
