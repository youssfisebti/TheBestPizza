<?php

namespace App\Twig;

use App\Entity\Pizza;
use App\Entity\User;
use App\Repository\PizzaRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private PizzaRepository $repository;

    public function __construct(PizzaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('isAllergic', [$this, 'UserAllergie']),
            new TwigFunction('hasAllergicIngredient', [$this, 'PizzaUserAllergie']),
        ];
    }

    public function UserAllergie(User $user, int $ingredientId): bool
    {
        $isAllergitic = false;
        $alergeticIngredients = array();
        if ($user->getAllergie()) {
            $alergeticIngredients = $user->getAllergie()->getIngredientsIds();
        }

        if (in_array($ingredientId, $alergeticIngredients)) {
            $isAllergitic = true;
        }

        return $isAllergitic;
    }

    public function PizzaUserAllergie(User $user, int $pizzaId): bool
    {
        $hasAllergitic = false;
        $alergeticIngredients = [];
        $pizzaIngredientIds = [];

        if ($user->getAllergie()) {
            $alergeticIngredients = $user->getAllergie()->getIngredientsIds();
        }

        $pizza = $this->repository->find($pizzaId);
        if ($pizza instanceof Pizza) {
            $pizzaIngredientIds = $pizza->getIngredientsIds();
        }

        if (!empty(array_intersect($alergeticIngredients, $pizzaIngredientIds))) {
            $hasAllergitic = true;
        }

        return $hasAllergitic;
    }
}