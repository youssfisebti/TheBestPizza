<?php

namespace App\Controller;

use App\Repository\PizzaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ClientController extends AbstractController
{

    #[Route('/', name: 'app_client_public')]
    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLIENT')")
     */
    public function espace(
        PizzaRepository    $pizzaRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $pizzas = $pizzaRepository->findAll();
        return $this->render('client/index.html.twig', [
            'pizzas' => $pizzas
        ]);
    }

    #[Route('/commande', name: 'app_commande')]
    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLIENT')")
     */
    public function commande(): Response
    {
        return $this->render('client/commande.html.twig');
    }
}
