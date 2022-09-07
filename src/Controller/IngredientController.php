<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/ingredients')]
class IngredientController extends AbstractController
{

    /**
     * This controller display all ingredients
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'app_ingredient_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(
        IngredientRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    /**
     * @param Request $request
     * @param IngredientRepository $ingredientRepository
     * @return Response
     */
    #[Route('/creation', name: 'app_ingredient_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(
        Request $request,
        IngredientRepository $ingredientRepository): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientRepository->add($ingredient, true);

            $this->addFlash(
                'success',
                'Votre ingrédient a été créé avec succès !'
            );

            return $this->redirectToRoute('app_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ingredient/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    /**
     * @param Ingredient $ingredient
     * @return Response
     */
    #[Route('/{id}', name: 'app_ingredient_show', methods: ['GET'])]
    public function show(Ingredient $ingredient): Response
    {
        return $this->render('ingredient/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * This controller allow us to edit an ingredient
     * @param Request $request
     * @param Ingredient $ingredient
     * @param IngredientRepository $ingredientRepository
     * @return Response
     */
    #[Route('/{id}/edition', name: 'app_ingredient_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Ingredient $ingredient, IngredientRepository $ingredientRepository): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredientRepository->add($ingredient, true);

            $this->addFlash(
                'success',
                'Votre ingrédient a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ingredient/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param Ingredient $ingredient
     * @param IngredientRepository $ingredientRepository
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_ingredient_delete', methods: ['POST'])]
    public function delete(Request $request, Ingredient $ingredient, IngredientRepository $ingredientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $ingredientRepository->remove($ingredient, true);

            $this->addFlash(
                'success',
                'Votre ingrédient a été supprimer avec succès !'
            );
        }

        return $this->redirectToRoute('app_ingredient_index', [], Response::HTTP_SEE_OTHER);
    }
}
