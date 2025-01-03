<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\UseCase;

use App\Exception\External\DataExistsExternalException;
use App\InfrastructureFacades\Lang;
use App\Layer\Domain\NotesCategory\Dto\DeleteNotesCategoryDto;
use App\Repository\NotesCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DeleteNotesCategoryUseCase
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NotesCategoryRepository $notesCategoryRepository,
    )
    {
    }

    public function handle(DeleteNotesCategoryDto $dto): void
    {
        $entity = $this->notesCategoryRepository->findOneBy(['id' => $dto->getId(), 'user_id' => $dto->getUserId()]);

        if (!$entity) {
            throw new DataExistsExternalException(Lang::t('error_notes_category_not_found'));
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}