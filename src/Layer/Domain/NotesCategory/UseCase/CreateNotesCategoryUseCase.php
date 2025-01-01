<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\UseCase;

use App\Entity\NotesCategory;
use App\Exception\External\DataExistsExternalException;
use App\InfrastructureFacades\Lang;
use App\Layer\Domain\NotesCategory\Dto\CreateNotesCategoryDto;
use App\Repository\NotesCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateNotesCategoryUseCase
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NotesCategoryRepository $notesCategoryRepository,
    )
    {

    }

    public function handle(CreateNotesCategoryDto $createNotesCategoryDto): NotesCategory
    {
        $find = $this->notesCategoryRepository->findOneBy([
            'user_id' => $createNotesCategoryDto->getUserId(),
            'name' => $createNotesCategoryDto->getName(),
        ]);

        if ($find) {
            throw new DataExistsExternalException(Lang::t('error_notes_category_already_exists'));
        }

        $entity = new NotesCategory();
        $entity->loadFromArray($createNotesCategoryDto->toArray());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }
}