<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\Dto;

use App\Layer\Base\BaseDto;

class CreateNotesCategoryDto extends BaseDto
{
    public function __construct(protected readonly int $user_id, protected readonly string $name)
    {
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}