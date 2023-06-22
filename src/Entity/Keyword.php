<?php

namespace App\Entity;

use App\Interface\ApiResponseObjectInterface;
use App\Repository\KeywordRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: KeywordRepository::class)]
#[ORM\UniqueConstraint(name: 'keyword__name_source', columns: ['name', 'source'])]
class Keyword implements EntityInterface, ApiResponseObjectInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    #[Groups(['get_score'])]
    private ?string $name = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    #[Groups(['get_score'])]
    private ?string $score = null;

    #[ORM\Column(length: 45)]
    #[Groups(['get_score'])]
    private ?string $source = null;
    #[ORM\Column(options: ["default" => 0, "comment" => "Total number of times the keyword has appeared in a positive context"])]
    private ?int $hitsRocks = 0;

    #[ORM\Column(options: ["default" => 0, "comment" => "Total number of times the keyword has appeared in a negative context"])]
    private ?int $hitsSucks = 0;

    #[ORM\Column(options: ["default" => 0, "comment" => "Total number of times the keyword has appeared in both positive and negative context (check parameter)"])]
    private ?int $hitsTotal = 0;

    #[ORM\Column(options: ["default" => 0])]
    #[Groups(['get_score'])]
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

    public function getHitsRocks(): ?int
    {
        return $this->hitsRocks;
    }

    public function setHitsRocks(?int $hitsRocks): self
    {
        $this->hitsRocks = $hitsRocks;

        return $this;
    }

    public function getHitsSucks(): ?int
    {
        return $this->hitsSucks;
    }

    public function setHitsSucks(?int $hitsSucks): self
    {
        $this->hitsSucks = $hitsSucks;

        return $this;
    }

    public function getHitsTotal(): ?int
    {
        return $this->hitsTotal;
    }

    public function setHitsTotal(?int $hitsTotal): self
    {
        $this->hitsTotal = $hitsTotal;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
