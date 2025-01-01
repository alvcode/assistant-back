<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Layer\Infrastructure\Security\UserFetcherInterface;
use App\Layer\Infrastructure\Security\AuthUserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Webmozart\Assert\Assert;

class UserFetcher implements UserFetcherInterface
{
    public function __construct(private readonly Security $security)
    {
    }

    public function getAuthUser(): AuthUserInterface
    {
        /** @var AuthUserInterface $user */
        $user = $this->security->getUser();

        Assert::notNull($user, 'Current user not found');
        Assert::isInstanceOf($user, AuthUserInterface::class, sprintf('Invalid user type %s', \get_class($user)));

        return $user;
    }
}