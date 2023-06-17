<?php

namespace App\Entity;

use App\Repository\KeywordRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KeywordRepository::class)]
#[ORM\UniqueConstraint(name: 'keyword__name_source', columns: ['name', 'source'])]
class Keyword
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    private ?string $source = null;

    #[ORM\Column(options: ["default" => 0])]
    private ?int $rocksCount = 0;

    #[ORM\Column(options: ["default" => 0])]
    private ?int $sucksCount = 0;

    #[ORM\Column(options: ["default" => 0])]
    private ?int $totalCount = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $score = null;

    #[ORM\Column(options: ["default" => 0])]
    private ?int $searchedCount = 0;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getRocksCount(): ?int
    {
        return $this->rocksCount;
    }

    public function setRocksCount(int $rocksCount): static
    {
        $this->rocksCount = $rocksCount;

        return $this;
    }

    public function getSucksCount(): ?int
    {
        return $this->sucksCount;
    }

    public function setSucksCount(int $sucksCount): static
    {
        $this->sucksCount = $sucksCount;

        return $this;
    }

    public function getTotalCount(): ?int
    {
        return $this->totalCount;
    }

    public function setTotalCount(int $totalCount): static
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): void
    {
        $this->score = $score;
    }

    public function getSearchedCount(): ?int
    {
        return $this->searchedCount;
    }

    public function setSearchedCount(int $searchedCount): static
    {
        $this->searchedCount = $searchedCount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
