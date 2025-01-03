<?php

declare(strict_types=1);

namespace App\Controller\ViewModels\Note;

use App\Controller\ViewModels\ViewModelBase;

class NoteVModelCollection extends ViewModelBase
{
    public function __construct(array $noteCollection)
    {
        foreach ($noteCollection as $note) {
            $this->result[] = (new NoteVModel($note))->getResult();
        }
    }

    public function getResult(): array
    {
        return $this->result;
    }
}