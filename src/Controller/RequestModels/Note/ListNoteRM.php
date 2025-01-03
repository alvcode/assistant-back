<?php

declare(strict_types=1);

namespace App\Controller\RequestModels\Note;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

use App\Controller\RequestModels\RequestModelBase;

class ListNoteRM extends RequestModelBase
{
    #[Assert\Type(Types::INTEGER)]
    public $category_id = null;
}