<?php

namespace App\Entity;

use App\Repository\CampaignsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignsRepository::class)]
class Campaigns
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CampaignName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?float $Budget = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    #[ORM\ManyToOne]
    private ?User $OwnerId = null;

    #[ORM\OneToMany(targetEntity: Fund::class, mappedBy: 'CampainId')]
    private Collection $FundID;

    public function __construct()
    {
        $this->FundID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampaignName(): ?string
    {
        return $this->CampaignName;
    }

    public function setCampaignName(string $CampaignName): static
    {
        $this->CampaignName = $CampaignName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->Budget;
    }

    public function setBudget(?float $Budget): static
    {
        $this->Budget = $Budget;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function getOwnerId(): ?User
    {
        return $this->OwnerId;
    }

    public function setOwnerId(?User $OwnerId): static
    {
        $this->OwnerId = $OwnerId;

        return $this;
    }

    /**
     * @return Collection<int, Fund>
     */
    public function getFundID(): Collection
    {
        return $this->FundID;
    }

    public function addFundID(Fund $fundID): static
    {
        if (!$this->FundID->contains($fundID)) {
            $this->FundID->add($fundID);
            $fundID->setCampainId($this);
        }

        return $this;
    }

    public function removeFundID(Fund $fundID): static
    {
        if ($this->FundID->removeElement($fundID)) {
            // set the owning side to null (unless already changed)
            if ($fundID->getCampainId() === $this) {
                $fundID->setCampainId(null);
            }
        }

        return $this;
    }

}

