<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WeaponRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: WeaponRepository::class)]
#[ApiResource]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['hero:read'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'Weapon', targetEntity: Hero::class)]
    private Collection $heroes;

    public function __construct()
    {
        $this->heroes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Hero>
     */
    public function getHeroes(): Collection
    {
        return $this->heroes;
    }

    public function addHero(Hero $hero): self
    {
        if (!$this->heroes->contains($hero)) {
            $this->heroes->add($hero);
            $hero->setWeapon($this);
        }

        return $this;
    }

    public function removeHero(Hero $hero): self
    {
        if ($this->heroes->removeElement($hero)) {
            // set the owning side to null (unless already changed)
            if ($hero->getWeapon() === $this) {
                $hero->setWeapon(null);
            }
        }

        return $this;
    }
}
