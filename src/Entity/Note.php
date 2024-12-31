<?php

namespace App\Entity;

use App\Layer\Base\BaseEntity;
use App\Repository\NoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(name: 'user_id', type: Types::INTEGER)]
    protected int $user_id;

    #[ORM\Column(name: 'category_id', type: Types::INTEGER, nullable: true)]
    protected ?int $category_id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $title = null;

    #[ORM\Column(type: Types::TEXT, length: 16777215, nullable: true)]
    protected ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected string $updated_at;

    // inversedBy - владелец связи
    #[ORM\ManyToOne(targetEntity: NotesCategory::class, inversedBy: "notes")]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    protected NotesCategory|null $notes_category = null;

    public function getId(): ?int
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

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
