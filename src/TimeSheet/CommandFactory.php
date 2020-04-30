<?php
declare(strict_types=1);

namespace App\TimeSheet;

use App\Shared\Exceptions\ValidationException;
use App\TimeSheet\Command\RejectTimeSheetCommand;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CommandFactory
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     *
     * @return RejectTimeSheetCommand
     *
     * @throws ValidationException|Exception
     */
    public function createRejectTimeSheetCommandFromRequest(Request $request): RejectTimeSheetCommand
    {
        $timeSheetId = $request->get('id', '');
        $reason = $request->get('reason', '');

        $errors = $this->validator->validate(
            $timeSheetId,
            [
                new NotBlank(['message' => 'TimeSheet id should not be blank']),
                new Type(['type' => 'string', 'message' => 'Id should be type of string']),
            ]
        );

        $errors->addAll(
            $this->validator->validate(
                $reason,
                [
                    new Type(['type' => 'string', 'message' => 'Reason should be type of string']),
                ]
            )
        );

        if ($errors->count() > 0) {
            throw new ValidationException($errors);
        }

        $userId = (string)random_int(1, 100); //authenticated user

        return new RejectTimeSheetCommand($userId, $timeSheetId, $reason);
    }
}
