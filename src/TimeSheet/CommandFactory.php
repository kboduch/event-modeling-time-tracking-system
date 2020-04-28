<?php
declare(strict_types=1);

namespace App\TimeSheet;

use App\TimeSheet\Command\RejectTimeSheetCommand;
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

    public function createRejectTimeSheetCommandFromRequest(Request $request): RejectTimeSheetCommand
    {
        $timeSheetId = $request->get('id', '');
        $reason = $request->get('reason', '');
        $errors = $this->validator->validate(
            $timeSheetId,
            [
                new NotBlank(),
                new Type(['type' => 'string'])
                //todo id format validation?
            ]

        );

        $errors->addAll(
            $this->validator->validate(
                $reason,
                [
                    new Type(['type' => 'string']),
                ]
            )
        );

        if ($errors->count() > 0) {
            throw new \Exception(); //todo replace with dedicated exception
        }

        return new RejectTimeSheetCommand($timeSheetId, $reason);
    }
}
