<?php

namespace App\Layer\Base\ErrorsExceptionDto;

use App\Layer\Base\BaseDto;

class ErrorExceptionDto extends BaseDto
{
    public const TYPE_INPUT_VALIDATE = 'input_validate';

//    protected string $type;
//    protected ?DetailErrorExceptionDtoCollection $details;

    public function __construct(protected string $type, protected ?DetailErrorExceptionDtoCollection $details)
    {

    }
}