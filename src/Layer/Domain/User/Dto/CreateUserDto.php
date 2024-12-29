<?php

declare(strict_types=1);

namespace App\Layer\Domain\User\Dto;

use App\Layer\Base\BaseDto;

class CreateUserDto extends BaseDto
{
    protected string $login;
    protected string $password;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}