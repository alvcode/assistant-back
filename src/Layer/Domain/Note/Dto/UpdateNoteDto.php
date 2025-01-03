<?php

declare(strict_types=1);

namespace App\Layer\Domain\Note\Dto;

use App\Layer\Base\BaseDto;

class UpdateNoteDto extends BaseDto
{
    public function __construct(
        protected readonly int $id,
        protected readonly int $user_id,
        protected readonly ?int $category_id,
        protected readonly ?string $title,
        protected readonly ?string $text
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

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}