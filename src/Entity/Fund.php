<?php

namespace App\Entity;

use App\Repository\FundRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FundRepository::class)]
class Fund
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $UserEmail = null;

    #[ORM\Column(length: 50)]
    private ?string $UserPassword = null;

    #[ORM\Column]
    private ?int $Amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\ManyToOne(inversedBy: 'FundID')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campaigns $CampainId = null;

    #[ORM\Column]
    private ?int $CampaignId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampainId(): ?Campaigns
    {
        return $this->CampainId;
    }

    public function setCampainId(Campaigns $CampainId): static
    {
        $this->CampainId = $CampainId;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->UserEmail;
    }

    public function setUserEmail(string $UserEmail): static
    {
        $this->UserEmail = $UserEmail;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->UserPassword;
    }

    public function setUserPassword(string $UserPassword): static
    {
        $this->UserPassword = $UserPassword;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): static
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getCampaignId(): ?int
    {
        return $this->CampaignId;
    }

    public function setCampaignId(int $CampaignId): static
    {
        $this->CampaignId = $CampaignId;

        return $this;
    }


}
