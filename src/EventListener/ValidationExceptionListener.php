<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationExceptionListener
{
    private bool $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $message = $exception->getMessage();
        $status = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        //if ($exception->getStatusCode() && $exception->getStatusCode() >= 400 && $exception->getStatusCode() <= 499) {
        if ($exception instanceof HttpException || $this->isDebug) {
            $result = [
                'message' => $message,
                'status' => $status,
                'code' => $exception->getCode(),
            ];
        } else {
            $result = [
                'message' => 'Internal Server Error',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'code' => 0,
            ];
        }

        if (method_exists($exception, 'getErrors')) {
            $result['errors'] = $exception->getErrors();
        }

        if ($this->isDebug) {
            $result['trace'] = $exception->getTrace();
        }

        $response = new JsonResponse($result, $status);
        $event->setResponse($response);
    }
}