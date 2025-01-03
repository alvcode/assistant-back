<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\UseCase;

use App\Entity\NotesCategory;
use App\Layer\Domain\NotesCategory\Dto\GetNotesCategoryDto;
use App\Repository\NotesCategoryRepository;

final readonly class GetNotesCategoryUseCase
{
    public function __construct(
        private NotesCategoryRepository $notesCategoryRepository,
    )
    {
    }

    /**
     * @param GetNotesCategoryDto $dto
     * @return array|NotesCategory[]
     */
    public function handle(GetNotesCategoryDto $dto): array
    {
        return $this->notesCategoryRepository->findBy(['user_id' => $dto->getUserId()]);
    }
}