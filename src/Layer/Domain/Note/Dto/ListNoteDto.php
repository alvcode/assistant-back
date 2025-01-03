<?php

declare(strict_types=1);

namespace App\Layer\Domain\Note\Dto;

use App\Layer\Base\BaseDto;

class ListNoteDto extends BaseDto
{
    public function __construct(
        protected readonly int $user_id,
        protected readonly ?int $filterByCategoryId = null,
    )
    {
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getFilterByCategoryId(): ?int
    {
        return $this->filterByCategoryId;
    }
}