<?php

declare(strict_types=1);

namespace App\Controller\RequestModels\Notes;
use App\Validator\AtLeastOneRequired\AtLeastOneRequiredConstraint;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

use App\Controller\RequestModels\RequestModelBase;

#[AtLeastOneRequiredConstraint(fields: ['title', 'text'])]
class CreateNoteRM extends RequestModelBase
{
    #[Assert\Type(Types::INTEGER)]
    public $category_id = null;

    #[Assert\Type(Types::STRING)]
    #[Assert\Length(max: 255)]
    public $title = null;

    #[Assert\Type(Types::STRING)]
    #[Assert\Length(max: 128000)]
    public $text = null;
}