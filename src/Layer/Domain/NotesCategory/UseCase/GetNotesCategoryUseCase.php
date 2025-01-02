<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\UseCase;

use App\Entity\NotesCategory;
use App\Exception\External\DataExistsExternalException;
use App\InfrastructureFacades\Lang;
use App\Layer\Domain\NotesCategory\Dto\UpdateNotesCategoryDto;
use App\Repository\NotesCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class GetNotesCategoryUseCase
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NotesCategoryRepository $notesCategoryRepository,
    )
    {
    }

    public function handle(UpdateNotesCategoryDto $dto): NotesCategory
    {
        $entity = $this->notesCategoryRepository->findOneBy([
            'id' => $dto->getId(),
            'user_id' => $dto->getUserId(),
        ]);

        if (!$entity) {
            throw new DataExistsExternalException(Lang::t('error_notes_category_not_found'));
        }

        $entity->loadFromArray($dto->toArray());
        $this->entityManager->flush();
        return $entity;
    }
}