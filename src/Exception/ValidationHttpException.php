<?php

namespace App\Exception;

use App\InfrastructureFacades\Lang;
use App\Layer\Base\ErrorsExceptionDto\ErrorExceptionDto;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationHttpException extends HttpException
{
    private ?ErrorExceptionDto $errors;

    public function __construct(?ErrorExceptionDto $errors = null, ?\Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(422, Lang::t('error_exception_validation'), $previous, $headers, $code);
        $this->errors = $errors;
    }

    public function getErrors(): ?ErrorExceptionDto
    {
        return $this->errors;
    }
}