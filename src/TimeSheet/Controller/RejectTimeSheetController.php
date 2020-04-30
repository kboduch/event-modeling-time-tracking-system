<?php
declare(strict_types=1);

namespace App\TimeSheet\Controller;

use App\Shared\Exception\NotAuthorizedException;
use App\Shared\Exceptions\ValidationException;
use App\TimeSheet\CommandFactory;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class RejectTimeSheetController
{
    /** @var CommandFactory */
    private $commandFactory;

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(CommandFactory $commandFactory, MessageBusInterface $commandBus)
    {
        $this->commandFactory = $commandFactory;
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $command = $this->commandFactory->createRejectTimeSheetCommandFromRequest($request);
            $this->commandBus->dispatch($command);

            return new JsonResponse(null, Response::HTTP_CREATED);
        } catch (HandlerFailedException $exception) {
            foreach ($exception->getNestedExceptions() as $nestedException) {
                if ($nestedException instanceof NotAuthorizedException) {
                    return new JsonResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
                }
            }

            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ValidationException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
