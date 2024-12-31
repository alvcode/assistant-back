<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\RequestModels\Notes\CreateNotesCategoryRM;
use App\Layer\Domain\User\Dictionary\UserRolesDictionary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(attribute: 'IS_AUTHENTICATED_FULLY', statusCode: 401)]
#[IsGranted(attribute: UserRolesDictionary::ROLE_USER, statusCode: 403)]
class NoteController extends AbstractController
{
    #[Route('/api/notes/category', name: 'notes_category_create', methods: ['POST'])]
    public function createCategory(CreateNotesCategoryRM $request): Response
    {
        $request = $request->validate();

        var_dump($request->toArray()); exit();
    }

    #[Route('/api/notes', name: 'notes_list', methods: ['GET'])]
    public function list(): Response
    {

        var_dump('im from notes list');
        exit();

        return new Response(null, Response::HTTP_CREATED);
    }
}
