<?php

declare(strict_types=1);

namespace App\Layer\Domain\User\Security;

interface UserFetcherInterface
{
    public function getAuthUser(): AuthUserInterface;
}