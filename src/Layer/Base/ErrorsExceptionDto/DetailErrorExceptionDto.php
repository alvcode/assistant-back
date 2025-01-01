<?php

namespace App\Layer\Base\ErrorsExceptionDto;

use App\Layer\Base\BaseDto;

class DetailErrorExceptionDto extends BaseDto
{
    public function __construct(protected ?string $key, protected string $message)
    {

    }
}