<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Repository\MessageRepository;

#[MongoDB\Document(
    collection: 'messages',
    repositoryClass: MessageRepository::class
)]
class Message
{
    #[MongoDB\Id]
    private ?string $id = null;

    #[MongoDB\Field(type: 'int')]
    private ?int $evenementId = null;

    #[MongoDB\Field(type: 'int')]
    private ?int $userId = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $pseudo = null;

    #[MongoDB\Field(type: 'string')]
    private ?string $contenu = null;

    #[MongoDB\Field(type: 'date_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[MongoDB\Field(type: 'bool')]
    private bool $deleted = false;

    #[MongoDB\Field(type: 'int', nullable: true)]
    private ?int $deletedBy = null;

    #[MongoDB\Field(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEvenementId(): ?int
    {
        return $this->evenementId;
    }

    public function setEvenementId(int $evenementId): static
    {
        $this->evenementId = $evenementId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?int $deletedBy): static
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}