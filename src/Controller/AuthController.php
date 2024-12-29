<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\RequestModels\Auth\RegisterRM;
use App\Layer\Domain\User\Dto\CreateUserDto;
use App\Layer\Domain\User\UseCase\CreateUserUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/api/auth/register', name: 'auth_register', methods: ['POST'])]
    public function register(RegisterRM $request, CreateUserUseCase $createUserUseCase): Response
    {
        $request = $request->validate();

        $createUserDto = new CreateUserDto();
        $createUserDto->loadFromArray($request->toArray());

        $createUserUseCase->handle($createUserDto);
        return new Response(null, Response::HTTP_CREATED);
    }
}
