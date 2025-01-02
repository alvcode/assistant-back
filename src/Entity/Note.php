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
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $user_id;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $category_id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $title = null;

    #[ORM\Column(type: Types::TEXT, length: 16777215, nullable: true)]
    protected ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected \DateTime $updated_at;

    // inversedBy - владелец связи
    #[ORM\ManyToOne(targetEntity: NotesCategory::class, inversedBy: "notes")]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    protected NotesCategory|null $notes_category = null;

    public function getNotesCategory(): ?NotesCategory
    {
        return $this->notes_category;
    }

    public function setNotesCategory(?NotesCategory $notes_category): void
    {
        $this->notes_category = $notes_category;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
