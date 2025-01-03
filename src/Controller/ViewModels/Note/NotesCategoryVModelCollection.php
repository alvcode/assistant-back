<?php

declare(strict_types=1);

namespace App\Controller\ViewModels\Note;

use App\Controller\ViewModels\ViewModelBase;

class NotesCategoryVModelCollection extends ViewModelBase
{
    public function __construct(array $notesCategories)
    {
        foreach ($notesCategories as $notesCategory) {
            $this->result[] = [
                'id' => $notesCategory->getId(),
                'name' => $notesCategory->getName(),
            ];
        }
    }

    public function getResult(): array
    {
        return $this->result;
    }
}