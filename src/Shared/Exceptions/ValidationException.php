<?php
declare(strict_types=1);

namespace App\Shared\Exceptions;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

final class ValidationException extends RuntimeException
{
    public function __construct(ConstraintViolationListInterface $violationList, Throwable $previous = null)
    {
        $message = sprintf(
            'Validation failed: %s',
            implode(
                ', ',
                array_map(
                    static function (ConstraintViolationInterface $violation) {
                        return $violation->getMessage();
                    },
                    (array)$violationList->getIterator()
                )
            )
        );

        parent::__construct($message, 0, $previous);
    }
}
