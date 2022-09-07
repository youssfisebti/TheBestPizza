<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Entity\User;
use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pizzas')]
class PizzaController extends AbstractController
{
    /**
     * This controller display all pizzas
     * @param PizzaRepository $pizzaRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'app_pizza_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(
        PizzaRepository $pizzaRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $pizzas= $paginator->paginate(
            $pizzaRepository->findAllPizza(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pizza/index.html.twig', [
            'pizzas' => $pizzas,
        ]);
    }

    /**
     * @param Request $request
     * @param PizzaRepository $pizzaRepository
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_pizza_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PizzaRepository $pizzaRepository): Response
    {
        $pizza = new Pizza();

        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pizzaRepository->add($pizza, true);

            $this->addFlash(
                'success',
                'Votre Pizza a été créé avec succès !'
            );

            return $this->redirectToRoute('app_pizza_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pizza/new.html.twig', [
            'pizza' => $pizza,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_pizza_show', methods: ['GET'])]
    public function show(Pizza $pizza): Response
    {
        return $this->render('pizza/show.html.twig', [
            'pizza' => $pizza,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_pizza_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pizza $pizza, PizzaRepository $pizzaRepository): Response
    {
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pizzaRepository->add($pizza, true);

            $this->addFlash(
                'success',
                'Votre Pizza a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_pizza_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pizza/edit.html.twig', [
            'pizza' => $pizza,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_pizza_delete', methods: ['POST'])]
    public function delete(Request $request, Pizza $pizza, PizzaRepository $pizzaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pizza->getId(), $request->request->get('_token'))) {
            $pizzaRepository->remove($pizza, true);

            $this->addFlash(
                'success',
                'Votre Pizza a été supprimer avec succès !'
            );
        }

        return $this->redirectToRoute('app_pizza_index', [], Response::HTTP_SEE_OTHER);
    }
}
