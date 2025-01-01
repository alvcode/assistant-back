<?php

declare(strict_types=1);

namespace App\Layer\Infrastructure\Security;

interface UserFetcherInterface
{
    public function getAuthUser(): AuthUserInterface;
}