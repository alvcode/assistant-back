<?php

declare(strict_types=1);

namespace App\Controller\ViewModels\Note;

use App\Controller\ViewModels\ViewModelInterface;
use App\Entity\Note;

class CreateNoteVModel implements ViewModelInterface
{
    private array $result = [];

    public function __construct(Note $note)
    {
        $this->result = [
            'id' => $note->getId(),
            'category_id' => $note->getCategoryId(),
            'title' => $note->getTitle(),
            'text' => $note->getText(),
            'updated_at' => $note->getUpdatedAt()->format('Y-m-d\TH:i:s\Z'),
        ];
    }

    public function getResult(): array
    {
        return $this->result;
    }


}