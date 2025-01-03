<?php

declare(strict_types=1);

namespace App\Layer\Domain\NotesCategory\Dto;

use App\Layer\Base\BaseDto;

class ListNotesCategoryDto extends BaseDto
{
    public function __construct(
        protected readonly int $user_id
    )
    {
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}