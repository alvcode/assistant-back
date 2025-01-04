<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\RequestModels\Note\CreateNoteRM;
use App\Controller\RequestModels\Note\CreateNotesCategoryRM;
use App\Controller\RequestModels\Note\ListNoteRM;
use App\Controller\RequestModels\Note\UpdateNoteRM;
use App\Controller\RequestModels\Note\UpdateNotesCategoryRM;
use App\Controller\ViewModels\Note\NotesCategoryVModelCollection;
use App\Controller\ViewModels\Note\NoteVModel;
use App\Controller\ViewModels\Note\NoteVModelCollection;
use App\Exception\External\DataExistsExternalException;
use App\Layer\Domain\Note\Dto\CreateNoteDto;
use App\Layer\Domain\Note\Dto\DeleteNoteDto;
use App\Layer\Domain\Note\Dto\ListNoteDto;
use App\Layer\Domain\Note\Dto\UpdateNoteDto;
use App\Layer\Domain\Note\UseCase\CreateNoteUseCase;
use App\Layer\Domain\Note\UseCase\DeleteNoteUseCase;
use App\Layer\Domain\Note\UseCase\ListNoteUseCase;
use App\Layer\Domain\Note\UseCase\UpdateNoteUseCase;
use App\Layer\Domain\NotesCategory\Dto\CreateNotesCategoryDto;
use App\Layer\Domain\NotesCategory\Dto\DeleteNotesCategoryDto;
use App\Layer\Domain\NotesCategory\Dto\ListNotesCategoryDto;
use App\Layer\Domain\NotesCategory\Dto\UpdateNotesCategoryDto;
use App\Layer\Domain\NotesCategory\UseCase\CreateNotesCategoryUseCase;
use App\Layer\Domain\NotesCategory\UseCase\DeleteNotesCategoryUseCase;
use App\Layer\Domain\NotesCategory\UseCase\ListNotesCategoryUseCase;
use App\Layer\Domain\NotesCategory\UseCase\UpdateNotesCategoryUseCase;
use App\Layer\Domain\User\Dictionary\UserRolesDictionary;
use App\Layer\Infrastructure\Security\UserFetcherInterface;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(attribute: 'IS_AUTHENTICATED_FULLY', statusCode: 401)]
#[IsGranted(attribute: UserRolesDictionary::ROLE_USER, statusCode: 403)]
class NoteController extends AbstractController
{
    #[Route('/api/notes/categories', name: 'notes_categories_list', methods: ['GET'])]
    public function listCategory(
        UserFetcherInterface $userFetcher,
        ListNotesCategoryUseCase $useCase
    ): Response
    {
        $getNotesCategoryDto = new ListNotesCategoryDto($userFetcher->getAuthUser()->getId());

        $collection = $useCase->handle($getNotesCategoryDto);
        return $this->json((new NotesCategoryVModelCollection($collection))->getResult());
    }

    #[Route('/api/notes/categories', name: 'notes_categories_create', methods: ['POST'])]
    public function createCategory(
        Request $request,
        CreateNotesCategoryRM $requestModel,
        UserFetcherInterface $userFetcher,
        CreateNotesCategoryUseCase $useCase
    ): Response
    {
        $requestValidate = $requestModel->setRequest($request);
        $requestValidate->validate();

        $createNotesCategoryDto = new CreateNotesCategoryDto($userFetcher->getAuthUser()->getId(), $requestValidate->name);

        $useCase->handle($createNotesCategoryDto);
        return new Response(null, Response::HTTP_CREATED);
    }

    #[Route('/api/notes/categories/{id}', name: 'notes_categories_update', methods: ['PUT'])]
    public function updateCategory(
        int $id,
        Request $request,
        UpdateNotesCategoryRM $requestModel,
        UserFetcherInterface $userFetcher,
        UpdateNotesCategoryUseCase $useCase
    ): Response
    {
        $requestValidate = $requestModel->setRequest($request);
        $requestValidate->validate();

        $updateNotesCategoryDto = new UpdateNotesCategoryDto($id, $userFetcher->getAuthUser()->getId(), $requestValidate->name);

        $useCase->handle($updateNotesCategoryDto);
        return new Response(null, Response::HTTP_CREATED);
    }

    #[Route('/api/notes/categories/{id}', name: 'notes_categories_delete', methods: ['DELETE'])]
    public function deleteCategory(
        int $id,
        UserFetcherInterface $userFetcher,
        DeleteNotesCategoryUseCase $useCase
    ): Response
    {
        $deleteNotesCategoryDto = new DeleteNotesCategoryDto($id, $userFetcher->getAuthUser()->getId());

        $useCase->handle($deleteNotesCategoryDto);
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws Exception
     * @throws ORMException
     */
    #[Route('/api/notes', name: 'notes_create', methods: ['POST'])]
    public function createNote(
        Request $request,
        CreateNoteRM $requestModel,
        UserFetcherInterface $userFetcher,
        CreateNoteUseCase $useCase
    ): Response
    {
        $requestValidate = $requestModel->setRequest($request);
        $requestValidate->validate();

        $createNoteDto = new CreateNoteDto(
            user_id: $userFetcher->getAuthUser()->getId(),
            category_id: $requestValidate->category_id,
            title: $requestValidate->title,
            text: $requestValidate->text
        );

        $noteEntity = $useCase->handle($createNoteDto);
        return $this->json(
            (new NoteVModel($noteEntity))->getResult(),
            Response::HTTP_CREATED
        );
    }

    /**
     * @throws Exception
     */
    #[Route('/api/notes/{id}', name: 'notes_update', methods: ['PUT'])]
    public function updateNote(
        int $id,
        Request $request,
        UpdateNoteRM $requestModel,
        UserFetcherInterface $userFetcher,
        UpdateNoteUseCase $useCase
    ): Response
    {
        $requestValidate = $requestModel->setRequest($request);
        $requestValidate->validate();

        $dto = new UpdateNoteDto(
            id: $id,
            user_id: $userFetcher->getAuthUser()->getId(),
            category_id: $requestValidate->category_id,
            title: $requestValidate->title,
            text: $requestValidate->text
        );
        $entity = $useCase->handle($dto);
        return $this->json((new NoteVModel($entity))->getResult(), Response::HTTP_CREATED);
    }

    /**
     * @throws DataExistsExternalException
     */
    #[Route('/api/notes/{id}', name: 'notes_delete', methods: ['DELETE'])]
    public function deleteNote(
        int $id,
        UserFetcherInterface $userFetcher,
        DeleteNoteUseCase $useCase
    ): Response
    {
        $dto = new DeleteNoteDto($id, $userFetcher->getAuthUser()->getId());
        $useCase->handle($dto);
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/notes', name: 'notes_list', methods: ['GET'])]
    public function listNote(
        Request $request,
        ListNoteRM $requestModel,
        UserFetcherInterface $userFetcher,
        ListNoteUseCase $useCase
    ): Response
    {
        $requestValidate = $requestModel->setRequest($request);
        $requestValidate->validate();

        $dto = new ListNoteDto(
            user_id: $userFetcher->getAuthUser()->getId(),
            filterByCategoryId: $requestValidate->category_id,
            sortBy: $requestValidate->sort_by,
            sortOrder: $requestValidate->sort_order
        );

        $collection = $useCase->handle($dto);
        return $this->json((new NoteVModelCollection($collection))->getResult());
    }
}
