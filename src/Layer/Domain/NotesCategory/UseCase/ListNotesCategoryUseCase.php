<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\UseCase;

use App\Entity\NotesCategory;
use App\Layer\Domain\NotesCategory\Dto\ListNotesCategoryDto;
use App\Repository\NotesCategoryRepository;

final readonly class ListNotesCategoryUseCase
{
    public function __construct(
        private NotesCategoryRepository $notesCategoryRepository,
    )
    {
    }

    /**
     * @param ListNotesCategoryDto $dto
     * @return array|NotesCategory[]
     */
    public function handle(ListNotesCategoryDto $dto): array
    {
        return $this->notesCategoryRepository->findBy(['user_id' => $dto->getUserId()]);
    }
}