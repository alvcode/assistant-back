<?php

declare(strict_types = 1);

namespace App\Layer\Domain\Note\UseCase;

use App\Entity\Note;
use App\Exception\External\DataExistsExternalException;
use App\InfrastructureFacades\Lang;
use App\Layer\Domain\Note\Dto\UpdateNoteDto;
use App\Repository\NoteRepository;
use App\Repository\NotesCategoryRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final readonly class UpdateNoteUseCase
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NoteRepository $noteRepository,
        private NotesCategoryRepository $notesCategoryRepository,
    )
    {
    }

    /**
     * @throws Exception
     * @throws DataExistsExternalException
     */
    public function handle(UpdateNoteDto $dto): Note
    {
        $entity = $this->noteRepository->findOneBy(['id' => $dto->getId(), 'user_id' => $dto->getUserId()]);

        if (!$entity) {
            throw new DataExistsExternalException(Lang::t('error_note_not_found'));
        }

        if ($dto->getCategoryId()) {
            $notesCategory = $this->notesCategoryRepository->findOneBy([
                'id' => $dto->getCategoryId(),
                'user_id' => $dto->getUserId(),
            ]);

            if (!$notesCategory) {
                throw new DataExistsExternalException(Lang::t('error_notes_category_not_found'));
            }
        }

        $entity->loadFromArray($dto->toArray());
        $entity->setUpdatedAt(
            (new DateTime('now', new DateTimeZone('UTC')))
        );

        $this->entityManager->flush();
        return $entity;
    }
}