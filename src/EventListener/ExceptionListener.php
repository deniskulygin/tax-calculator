<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse(['message' => $exception->getMessage()]);

        if ($exception->getPrevious() instanceof ValidationFailedException) {
            $responseBody = [];

            foreach ($exception->getPrevious()?->getViolations() as $violation) {
                $responseBody[] = ['message' => $violation->getMessage()];
            }

            $response->setData($responseBody);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->add($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
