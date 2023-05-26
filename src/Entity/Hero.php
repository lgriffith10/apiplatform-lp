<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\HeroRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Api\HeroController;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HeroRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'hero:read'],
)]
#[Get]
#[Get(
    uriTemplate: '/heroes/by-uuid/{uuid}',
    controller: HeroController::class,
    name: 'api_hero_by_uuid_get',
)]
#[GetCollection]
class Hero
{
    #[Groups(['hero:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['hero:read'])]
    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[Groups(['hero:read'])]
    #[ORM\Column(length: 255)]
    private ?string $displayName = null;

    #[Groups(['hero:read'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups(['hero:read'])]
    #[ORM\Column(length: 255)]
    private ?string $role_name = null;

    #[Groups(['hero:read'])]
    #[ORM\Column(length: 255)]
    private ?string $role_img = null;

    #[Groups(['hero:read'])]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Groups(['hero:read'])]
    #[ORM\ManyToOne(inversedBy: 'heroes')]
    private ?Weapon $weapon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRoleName(): ?string
    {
        return $this->role_name;
    }

    public function setRoleName(string $role_name): self
    {
        $this->role_name = $role_name;

        return $this;
    }

    public function getRoleImg(): ?string
    {
        return $this->role_img;
    }

    public function setRoleImg(string $role_img): self
    {
        $this->role_img = $role_img;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): self
    {
        $this->weapon = $weapon;

        return $this;
    }
}
