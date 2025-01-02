<?php

declare(strict_types=1);

namespace App\Controller\RequestModels\Note;
use Symfony\Component\Validator\Constraints as Assert;

use App\Controller\RequestModels\RequestModelBase;

class UpdateNotesCategoryRM extends RequestModelBase
{
    #[Assert\Type('string')]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 255)]
    public $name;
}