<?php

namespace App\Controller\Common;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ErrorController
{
    public function __invoke(FlattenException $exception): JsonResponse
    {
//        $statusCode = $exception->getStatusCode();
//
//        return new JsonResponse([
//            'error' => [
//                'code' => $statusCode,
//                'message' => Response::$statusTexts[$statusCode] ?? 'Unknown error',
//                'details' => $exception->getMessage(),
//            ],
//        ], $statusCode);
    }
}