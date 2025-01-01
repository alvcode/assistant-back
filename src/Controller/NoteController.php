<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\RequestModels\Notes\CreateNoteRM;
use App\Controller\RequestModels\Notes\CreateNotesCategoryRM;
use App\Layer\Domain\Note\Dto\CreateNoteDto;
use App\Layer\Domain\Note\UseCase\CreateNoteUseCase;
use App\Layer\Domain\NotesCategory\Dto\CreateNotesCategoryDto;
use App\Layer\Domain\NotesCategory\UseCase\CreateNotesCategoryUseCase;
use App\Layer\Domain\User\Dictionary\UserRolesDictionary;
use App\Layer\Infrastructure\Security\UserFetcherInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(attribute: 'IS_AUTHENTICATED_FULLY', statusCode: 401)]
#[IsGranted(attribute: UserRolesDictionary::ROLE_USER, statusCode: 403)]
class NoteController extends AbstractController
{
    #[Route('/api/notes/category', name: 'notes_category_create', methods: ['POST'])]
    public function createCategory(
        CreateNotesCategoryRM $request,
        UserFetcherInterface $userFetcher,
        CreateNotesCategoryUseCase $useCase
    ): Response
    {
        $request = $request->validate();
        $createNotesCategoryDto = new CreateNotesCategoryDto($userFetcher->getAuthUser()->getId(), $request->name);

        $useCase->handle($createNotesCategoryDto);
        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/notes', name: 'notes_create', methods: ['POST'])]
    public function createNote(
        CreateNoteRM $request,
        UserFetcherInterface $userFetcher,
        CreateNoteUseCase $useCase
    ): Response
    {
        $request = $request->validate();
        $createNoteDto = new CreateNoteDto(
            user_id: $userFetcher->getAuthUser()->getId(),
            category_id: $request->category_id,
            title: $request->title,
            text: $request->text
        );

        $noteEntity = $useCase->handle($createNoteDto);

        var_dump($noteEntity->toArray()); exit();
    }

    #[Route('/api/notes', name: 'notes_list', methods: ['GET'])]
    public function list(): Response
    {

        var_dump('im from notes list');
        exit();

        return new Response(null, Response::HTTP_CREATED);
    }
}
