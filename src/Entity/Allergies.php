<?php

namespace App\Entity;

use App\Repository\AllergiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllergiesRepository::class)]
class Allergies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    private Collection $ingredients;

    #[ORM\OneToOne(mappedBy: 'allergie', cascade: ['persist', 'remove'])]
    private ?User $user = null;


    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setAllergie(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getAllergie() !== $this) {
            $user->setAllergie($this);
        }

        $this->user = $user;

        return $this;
    }


    public function getIngredientsIds(): array
    {
        $ids = [];
        foreach ($this->getIngredients() as $ingredient) {
            $ids[] = $ingredient->getId();
        }
        return $ids;
    }

}
