<?php

namespace App\EventListener;

use App\InfrastructureFacades\Lang;
use App\Layer\Base\ErrorsExceptionDto\ErrorExceptionDto;
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
                'message' => Lang::t('error_internal_server_error'),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'code' => 0,
            ];
        }

        if (method_exists($exception, 'getErrors')) {
            if ($exception->getErrors() instanceof ErrorExceptionDto) {
                $result['errors'] = $exception->getErrors()->toArray();
            }
        }

        if ($this->isDebug) {
            $result['trace'] = $exception->getTrace();
        }

        $response = new JsonResponse($result, $status);
        $event->setResponse($response);
    }
}