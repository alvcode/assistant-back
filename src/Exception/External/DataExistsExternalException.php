<?php

namespace App\Exception\External;

use App\InfrastructureFacades\Lang;
use App\Layer\Base\ErrorsExceptionDto\ErrorExceptionDto;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DataExistsExternalException extends HttpException
{
    public function __construct(string $message = '', ?\Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(422, $message, $previous, $headers, $code);
    }
}