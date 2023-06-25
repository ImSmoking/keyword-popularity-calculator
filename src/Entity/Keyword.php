<?php

namespace App\Entity;

use App\Interface\ApiResponseObjectInterface;
use App\Repository\KeywordRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KeywordRepository::class)]
#[ORM\UniqueConstraint(name: 'keyword__term_source', columns: ['term', 'source'])]
class Keyword implements EntityInterface, ApiResponseObjectInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_score'])]
    #[Assert\Length(min: 2, max: 5, groups: ['length'])]
    private ?string $term = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    #[Groups(['get_score'])]
    private ?string $score = null;

    #[ORM\Column(length: 45)]
    #[Groups(['get_score'])]
    private ?string $source = null;

    #[ORM\Column(options: ["default" => 0, "comment" => "Total number of times the keyword has appeared in a positive context"])]
    private ?int $hitsPositive = 0;

    #[ORM\Column(options: ["default" => 0, "comment" => "Total number of times the keyword has appeared in a negative context"])]
    private ?int $hitsNegative = 0;

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

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(string $term): static
    {
        $this->term = $term;

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

    public function getHitsPositive(): ?int
    {
        return $this->hitsPositive;
    }

    public function setHitsPositive(?int $hitsPositive): self
    {
        $this->hitsPositive = $hitsPositive;

        return $this;
    }

    public function getHitsNegative(): ?int
    {
        return $this->hitsNegative;
    }

    public function setHitsNegative(?int $hitsNegative): self
    {
        $this->hitsNegative = $hitsNegative;

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

    public function increaseSearch(): self
    {
        $this->searchedCount += 1;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt = null): static
    {
        if (is_null($createdAt)) {
            $createdAt = new DateTimeImmutable();
        }
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
