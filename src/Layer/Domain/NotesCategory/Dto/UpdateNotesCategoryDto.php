<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\Dto;

use App\Layer\Base\BaseDto;

class UpdateNotesCategoryDto extends BaseDto
{
    public function __construct(
        protected readonly int $id,
        protected readonly int $user_id,
        protected readonly string $name
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
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