<?php

namespace App\Controller;

use App\Entity\Allergies;
use App\Form\AllergiesType;
use App\Repository\AllergiesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/allergies')]
class AllergiesController extends AbstractController
{

    #[Route('/', name: 'app_allergies_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function new(Request $request, AllergiesRepository $allergiesRepository): Response
    {
        if ($this->getUser()->getAllergie() === null) {
            $allergy = new Allergies();
            $allergy->setUser($this->getUser());
        } else {
            $allergy = $this->getUser()->getAllergie();
        }


        $form = $this->createForm(AllergiesType::class, $allergy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $allergiesRepository->add($allergy, true);

            return $this->redirectToRoute('app_allergies_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('allergies/new.html.twig', [
            'allergy' => $allergy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_allergies_show', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function show(Allergies $allergy): Response
    {
        return $this->render('allergies/show.html.twig', [
            'allergy' => $allergy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_allergies_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function edit(Request $request, Allergies $allergy, AllergiesRepository $allergiesRepository): Response
    {
        $form = $this->createForm(AllergiesType::class, $allergy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $allergiesRepository->add($allergy, true);

            return $this->redirectToRoute('app_allergies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('allergies/edit.html.twig', [
            'allergy' => $allergy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_allergies_delete', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function delete(Request $request, Allergies $allergy, AllergiesRepository $allergiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allergy->getId(), $request->request->get('_token'))) {
            $allergiesRepository->remove($allergy, true);
        }

        return $this->redirectToRoute('app_allergies_index', [], Response::HTTP_SEE_OTHER);
    }
}
