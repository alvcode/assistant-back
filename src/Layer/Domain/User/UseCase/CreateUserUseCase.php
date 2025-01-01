<?php

declare(strict_types=1);

namespace App\Layer\Domain\User\UseCase;

use App\Entity\User;
use App\Exception\External\DataExistsExternalException;
use App\InfrastructureFacades\Lang;
use App\Layer\Domain\User\Dictionary\UserRolesDictionary;
use App\Layer\Domain\User\Dto\CreateUserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class CreateUserUseCase
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface      $entityManager,
        private UserRepository              $userRepository
    )
    {

    }

    public function handle(CreateUserDto $createUserDto): User
    {
        $find = $this->userRepository->findOneBy(['login' => $createUserDto->getLogin()]);

        if ($find) {
            throw new DataExistsExternalException(Lang::t('error_user_already_exists'));
        }

        $user = new User();
        $user->setLogin($createUserDto->getLogin());
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $createUserDto->getPassword())
        );
        $user->setRoles(UserRolesDictionary::DEFAULT_USER_ROLES);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}