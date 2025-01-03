<?php

namespace App\Entity;

use App\Layer\Base\BaseEntity;
use App\Repository\NotesCategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesCategoryRepository::class)]
class NotesCategory extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $user_id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    protected string $name;

    // mappedBy -  не является владельцем, оно просто "зеркалирует" связь.
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: "notes_category")]
    protected Collection|null $notes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNotes(): ?Collection
    {
        return $this->notes;
    }
}
