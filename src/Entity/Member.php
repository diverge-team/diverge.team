<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MemberRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ApiResource]
class Member
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $discordUserId = null;

    #[ORM\Column]
    private ?int $nbMessages = null;

    #[ORM\Column]
    private ?int $xp = null;

    #[ORM\Column]
    private ?int $totalXp = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscordUserId(): ?string
    {
        return $this->discordUserId;
    }

    public function setDiscordUserId(string $discordUserId): self
    {
        $this->discordUserId = $discordUserId;

        return $this;
    }

    public function getNbMessages(): ?int
    {
        return $this->nbMessages;
    }

    public function setNbMessages(int $nbMessages): self
    {
        $this->nbMessages = $nbMessages;

        return $this;
    }

    public function getXp(): ?int
    {
        return $this->xp;
    }

    public function setXp(int $xp): self
    {
        $this->xp = $xp;

        return $this;
    }

    public function getTotalXp(): ?int
    {
        return $this->totalXp;
    }

    public function setTotalXp(int $totalXp): self
    {
        $this->totalXp = $totalXp;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }
}
