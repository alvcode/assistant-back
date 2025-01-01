<?php

declare(strict_types = 1);

namespace App\Layer\Domain\Note\UseCase;

use App\Entity\Note;
use App\Layer\Domain\Note\Dto\CreateNoteDto;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final readonly class CreateNoteUseCase
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(CreateNoteDto $dto): Note
    {
        $note = new Note();
        $note->loadFromArray($dto->toArray());
        $note->setUpdatedAt(
            (new DateTime('now', new DateTimeZone('UTC')))
        );

        $this->entityManager->persist($note);
        $this->entityManager->flush();
        return $note;
    }
}