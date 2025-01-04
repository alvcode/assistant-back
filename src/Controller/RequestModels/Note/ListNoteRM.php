<?php

declare(strict_types=1);

namespace App\Controller\RequestModels\Note;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

use App\Controller\RequestModels\RequestModelBase;

class ListNoteRM extends RequestModelBase
{
    #[Assert\Type(Types::INTEGER)]
    public ?int $category_id = null;

    #[Assert\Type(Types::STRING)]
    #[Assert\Length(max: 30)]
    #[Assert\Choice(['id', 'updated_at'])]
    public ?string $sort_by = null;

    #[Assert\Type(Types::STRING)]
    #[Assert\Length(max: 4)]
    #[Assert\Choice(['desc', 'asc'])]
    public ?string $sort_order = null;
}