<?php

declare(strict_types = 1);

namespace App\Layer\Domain\Note\UseCase;

use App\Entity\Note;
use App\Exception\External\DataExistsExternalException;
use App\Layer\Domain\Note\Dto\ListNoteDto;
use App\Repository\NoteRepository;

final readonly class ListNoteUseCase
{
    public function __construct(
        private NoteRepository $noteRepository,
    )
    {
    }

    /**
     * @throws DataExistsExternalException
     * @return array|Note[]
     */
    public function handle(ListNoteDto $dto): array
    {
        return $this->noteRepository->listByParams($dto);
    }
}