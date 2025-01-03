<?php

declare(strict_types = 1);

namespace App\Layer\Domain\Note\UseCase;

use App\Exception\External\DataExistsExternalException;
use App\InfrastructureFacades\Lang;
use App\Layer\Domain\Note\Dto\DeleteNoteDto;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DeleteNoteUseCase
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NoteRepository $noteRepository,
    )
    {
    }

    /**
     * @throws DataExistsExternalException
     */
    public function handle(DeleteNoteDto $dto): void
    {
        $entity = $this->noteRepository->findOneBy(['id' => $dto->getId(), 'user_id' => $dto->getUserId()]);

        if (!$entity) {
            throw new DataExistsExternalException(Lang::t('error_note_not_found'));
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}