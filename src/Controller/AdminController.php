<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use App\Repository\PizzaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        PizzaRepository      $pizzaRepository,
        IngredientRepository $repository,
        PaginatorInterface   $paginator,
        Request              $request
    ): Response
    {
        $pizzas = $paginator->paginate(
            $pizzaRepository->findAllPizza(),
            $request->query->getInt('page', 1),
            10
        );

        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/index.html.twig', [
            'pizzas' => $pizzas,
            'ingredients' => $ingredients
        ]);
    }
}
