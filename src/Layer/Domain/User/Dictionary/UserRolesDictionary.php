<?php

declare(strict_types=1);

namespace App\Layer\Domain\User\Dictionary;

class UserRolesDictionary
{
    public const ROLE_USER = 'ROLE_USER';

    public const DEFAULT_USER_ROLES = [
        self::ROLE_USER,
    ];
}